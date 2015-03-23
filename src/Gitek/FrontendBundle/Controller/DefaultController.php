<?php

namespace Gitek\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Gitek\BackendBundle\Entity\Usuario;
use Gitek\FrontendBundle\Entity\Log;
use Gitek\FrontendBundle\Entity\Logdetail;


class DefaultController extends Controller
{
    public function loginAction (Request $request) {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($this->getUser()) { # el usuario estña
            return $this->redirect($this->generateUrl('dashboard'));
        }

        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()) { # el usuario está logueado
            return $this->redirect($this->generateUrl('dashboard'));
        }

        $usuarios = $em->getRepository('BackendBundle:Usuario')->findAll();


        return $this->render('FrontendBundle:Default:index.html.twig', array(
            'usuarios' => $usuarios,
            'error' => $error
        ));
    }

    public function logincheckAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('userid');
        $usuario = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Unable to find $usuario entity.');
        }

        if ( $usuario->getAdmin() == 1 ) {
            $token = new UsernamePasswordToken($usuario, null, 'main', array('ROLE_ADMIN'));
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
            return $this->redirect($this->generateUrl('backend_dashboard'));

        } else {
            $token = new UsernamePasswordToken($usuario, null, 'main', array('ROLE_USER'));
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
            return $this->redirect($this->generateUrl('dashboard'));
        }
    }

    public function logoutAction(){
        $this->get("request")->getSession()->invalidate();
        $this->get("security.context")->setToken(null);
        $this->get("session")->setFlash('message.success', true);
        return new RedirectResponse($this->generateUrl('login'));
    }

    public function dashboardAction() {

        $usuario = $this->getUser();
        $of='';
        $operacion = '';
        $componentes = '';
        $log = '';
        $mijson = '';

        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion,
            'componentes' => $componentes,
            'log' => $log,
            'mijson' => $mijson
        ));
    }

    public function findofAction(Request $request,$of=null) {
        if ( $request->getMethod() == "POST" ) {
            $of = $request->request->get('of'); //gets POST var.
            return $this->redirect($this->generateUrl("find_of", array( 'of' => $of) ));
        }

        // miramos si la ya han comenzado con la OF
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findByOf($of);
        if  ( count($log) > 0 ) {

        }

        $client = $this->get('guzzle.client');
        $request = $client->get('http://10.0.0.12:5080/expertis/delaoferta?of=' . $of);
        $response = $request->send();
        $data = $response->json();

        if ( !count($data) > 0 ) {
            $of = "no encontrado";
        }

        $log = new Log();
        $log->setOf($of);
        $em->persist($log);
        $em->flush();

        $usuario = $this->getUser();
        $operacion = "";
        $componentes = "";

        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion,
            'componentes' => $componentes
        ));
    }

    public function findoperacionAction(Request $request, $operacion=null) {
        if ( $request->getMethod() == "POST" ) {
            $operacion = $request->request->get('operacion'); //gets POST var.

            return $this->redirect($this->generateUrl("find_of_operacion", array( 'operacion' => $operacion) ));
        }
        $client = $this->get('guzzle.client');
        $request = $client->get('http://10.0.0.12:5080/expertis/poroperacion?operacion=' . $operacion);
        $response = $request->send();
        $data = $response->json();

        if ( count($data) > 0 ) {
            $of = $data[0]['NOrden'];

        } else {
            $operacion = "no encontrado";
            $of = "";
        }

        $usuario = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));

        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario'   => $usuario,
            'of'        => $of,
            'operacion' => $operacion,
            'log'       => $log,
            'mijson'    => $data
        ));
    }

    public function addComponenteAction(Request $request) {
        $usuario = $this->getUser();
        $of = $request->request->get("of");
        $operacion = $request->request->get("operacion");
        $componente = $request->request->get("componente");
        $logid = $request->request->get('logid');

        // 1-. comprobar que pertenece a la OF correcta y Operación correcta
        $client = $this->get('guzzle.client');
        $request = $client->get('http://10.0.0.12:5080/expertis/poroperacion?operacion=' . $operacion);
        $response = $request->send();
        $datos = $response->json();

        $bilaketa = $this->search_objects($datos, 'IDComponente', $componente);

        if ( count($bilaketa) == 0 )
        {
            $response = new Response();
            $response->setStatusCode(204);
            return $response;
        }

        // 2-. comprobar si esta dentro de la tabla log

        $em = $this->getDoctrine()->getManager();

        if (!$logid) {
            $log = $em->getRepository('FrontendBundle:Log')->findByOfOperacionComponente($of, $operacion,$componente);
        } else {
            $log = $em->getRepository('FrontendBundle:Log')->find($logid);
        }



        if ( count($log) === 0 ) {
            $log = new Log();
            $log->setOf($of);
            $log->setOperacion($operacion);
            $em->persist($log);

        }

        $midet = $em->getRepository('FrontendBundle:Logdetail')->findByComponente($componente);

        if ( count($midet) > 0 ) {
            $resp = array('existe'=>1);
            $serializador = $this->container->get('serializer');
            $respuesta = new Response($serializador->serialize($resp, 'json'));
            $respuesta->headers->set('Content-Type', 'application/json');
            return $respuesta;
        } else {
            $det = new Logdetail();
            $det->setLog($log);
            $user = $em->getRepository('BackendBundle:Usuario')->find($usuario->getId());
            $det->setUsuario($user);

            $det->setComponente($componente);
            $det->setDescripcion($bilaketa[0]["DescArticulo"]);
            $det->setPosicion1($bilaketa[0]["PosicionFeeder"]);
            $det->setPosicion2($bilaketa[0]["Observaciones"]);
            $det->setCantidad($bilaketa[0]["QNecesaria"]);
            $em->persist($det);

            $em->flush();

            $serializador = $this->container->get('serializer');
            $respuesta = new Response($serializador->serialize($det, 'json'));
            $respuesta->headers->set('Content-Type', 'application/json');
            return $respuesta;
        }
    }

    protected function search_objects($objects, $key, $value) { // might contain bugs as I typed in in SO on the go
        $return = array();
        foreach ($objects as $object) {
            if (isset($object[$key]) && $object[$key] == $value) {
               $return[] = $object;
            }
        }
        return $return;
    }

    public function removeComponentAction(Request $request) {
        $id = $request->request->get("idlogdetail");

        $em = $this->getDoctrine()->getManager();
        $logdetail = $em->getRepository('FrontendBundle:Logdetail')->find($id);


        if (!$logdetail) {
            $response = new Response();
            $response->setStatusCode(204);
            return $response;
        }

        $em->remove($logdetail);
        $em->flush();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }

}
