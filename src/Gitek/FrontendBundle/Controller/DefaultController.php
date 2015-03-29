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
use Gitek\FrontendBundle\Entity\Logbobina;


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
            return $this->redirect($this->generateUrl('backend'));

        } else {
            $token = new UsernamePasswordToken($usuario, null, 'main', array('ROLE_USER'));
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
            return $this->redirect($this->generateUrl('menu'));
        }
    }

    public function logoutAction(){
        $this->get("request")->getSession()->invalidate();
        $this->get("security.context")->setToken(null);
        $this->get("session")->setFlash('message.success', true);
        return new RedirectResponse($this->generateUrl('login'));
    }

    public function menuAction() {


        return $this->render('FrontendBundle:Default:menu.html.twig');
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

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }

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

    public function findoperacionAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }

        $operacion = $request->request->get('operacion'); //gets POST var.

        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
        if ($log) {
            if ( $log->getValidacion3() == 1 ) {
                return $this->redirect($this->generateUrl("validacion4", array( 'operacion' => $operacion) ));
            } elseif ( $log->getValidacion2() == 1 ) {
                return $this->redirect($this->generateUrl("validacion3", array( 'operacion' => $operacion) ));
            }elseif ( $log->getValidacion1() == 1 ) {
                return $this->redirect($this->generateUrl("validacion2", array( 'operacion' => $operacion) ));
            } else {
                return $this->redirect($this->generateUrl("validacion1", array( 'operacion' => $operacion) ));
            }
        } else {
            return $this->redirect($this->generateUrl("validacion1", array( 'operacion' => $operacion) ));
        }
    }

    public function validacion1Action(Request $request, $operacion=null) {

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }

        if ( $request->getMethod() == "POST" ) {
            $operacion = $request->request->get('operacion'); //gets POST var.
//
//            return $this->redirect($this->generateUrl("validacion1", array( 'operacion' => $operacion) ));
        }

        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));

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

        if (!$log) {
            $log = new Log();
            $log->setOperacion($operacion);
            $log->setOf($of);
            $em->persist($log);
            $em->flush();
        }

        $usuario = $this->getUser();

        return $this->render('FrontendBundle:Default:validacion1.html.twig', array(
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
        $postcomponente = $request->request->get("componente");

        /* CODIGO DATAMATRIX:
        R + 10/12 c + $ + LOTE + $ + cantidad + UUID
        EjemploS: R11TR1F0022$3813712832/PE268754C101$3000$4642
        R11TR1F0022$3813712832-PE268754C101$3000$4642
        R11TR1F0022$3813712832-PE268754C101$3000$4640
        R11TR1F0022$3813712832-PE268754C101$3000$4641
        R11TR1F0022$3813712832-PE268754C101$3000$4639
        R11TR1F0022$3813712832-PE268754C101$3000$4637
        R11TR1F0022$3813712832-PE268754C101$3000$4638
        R11di1f0014$3813712832-PE225495C301$3000$4617
        R11DI740005$3813712832-VD46BRG17$2500$4622
        R11TR1F0022$3813712832-PE268754C101$3000$4635
        R11TR1F0022$3813712832-PE268754C101$3000$4634
        R11TR1F0022$3813712832-PE268754C101$3000$4642
        */

        $compo = explode("$", $postcomponente);

        $componente = substr($compo[0], 1,strlen ($compo[0]));
        $lote = $compo[1];
        $cantidad = $compo[2];
        $uuid = $compo[3];


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

        //$midet = $em->getRepository('FrontendBundle:Logdetail')->findByComponente($componente);
        $midet = $em->getRepository('FrontendBundle:Logdetail')->findByComponentedatamatrix($componente, $lote, $uuid);

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
            $det->setCantidad($cantidad);
            $det->setLote($lote);
            $det->setUuid($uuid);

            $em->persist($det);
            $em->flush();

            // Comprobar si completado:
            $jsoncount = count($datos);
            $logcount  = count($log->getDetalles());

            if ( $jsoncount == $logcount ) {

                $log->setValidacion1(true);
                $em->flush();

            }

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

    public function dovalidacion2Action($operacion) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
        $log->setValidacion2(1);
        $em->persist($log);
        $em->flush();
        return $this->redirect($this->generateUrl('validacion3', array('operacion'=>$operacion)));
    }

    public function validacion2Action($operacion) {
        // Serigrafia
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));

        $questions = $em->getRepository('BackendBundle:ValidacionSerigrafia')->findSerigrafiaVisible();

        return $this->render('FrontendBundle:Default:validacion2.html.twig', array(
            'log' => $log,
            'usuario' => $usuario,
            'questions' => $questions,
        ));
    }

    public function validacion3Action($operacion) {
        // Pick&Place
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));

        $questions = $em->getRepository('BackendBundle:ValidacionPickPlace')->findPickplaceVisible();

        return $this->render('FrontendBundle:Default:validacion3.html.twig', array(
            'log' => $log,
            'usuario' => $usuario,
            'questions' => $questions,
        ));
    }

    public function dovalidacion3Action($operacion) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
        $log->setValidacion3(1);
        $em->persist($log);
        $em->flush();
        return $this->redirect($this->generateUrl('validacion4', array('operacion'=>$operacion)));
    }

    public function validacion4Action($operacion) {
        // Horno
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));


        return $this->render('FrontendBundle:Default:validacion4.html.twig', array(
            'log' => $log,
            'usuario' => $usuario,
        ));
    }

    public function dovalidacion4Action($operacion) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
        $log->setValidacion4(1);
        $em->persist($log);
        $em->flush();
        return $this->redirect($this->generateUrl('validacion5', array('operacion'=>$operacion)));
    }

    public function validacion5Action($operacion) {
        // Horno
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));


        return $this->render('FrontendBundle:Default:validacion5.html.twig', array(
            'log' => $log,
            'usuario' => $usuario,
        ));
    }

    public function dovalidacion5Action($operacion) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
        $log->setValidacion5(1);
        $em->persist($log);
        $em->flush();
        return $this->redirect($this->generateUrl('validacion6', array('operacion'=>$operacion)));
    }

    public function validacion6Action($operacion) {
        // Horno
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));


        return $this->render('FrontendBundle:Default:validacion6.html.twig', array(
            'log' => $log,
            'usuario' => $usuario,
        ));
    }

    public function cabiarbobinaAction() {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $of = "";
        $operacion = "";


        return $this->render('FrontendBundle:Default:cambiarbobina.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion,
            'error'=>0,
        ));
    }

    public function cambioBobinaLeeOfAction(Request $request) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $operacion = "";

        if ( $request->getMethod() == "POST" ) {
            $of = $request->request->get('of'); //gets POST var.
        }

        // Comprobamos que tenemos un Log para esa OF
        $em = $this->getDoctrine()->getManager();
        $log = $em->getRepository('FrontendBundle:Log')->findOneByOf($of);

        if ($log) {
            return $this->render('FrontendBundle:Default:cambiarbobina.html.twig', array(
                'usuario' => $usuario,
                'of' => $of,
                'log' => $log,
                'operacion' => $operacion,
                'error'=>0
            ));
        } else {
            return $this->render('FrontendBundle:Default:cambiarbobina.html.twig', array(
                'usuario' => $usuario,
                'of' => '',
                'log' => '',
                'operacion' => '',
                'error'=>1
            ));
        }


    }

    public function cambioBobinaLeeOperacionAction(Request $request) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $usuario = $this->getUser();
        $operacion = "";

        $em = $this->getDoctrine()->getManager();



        $of = $request->request->get('of'); //gets POST var.
        $operacion = $request->request->get('operacion');
        $logid = $request->request->get('logid');
        $log = $em->getRepository('FrontendBundle:Log')->find($logid);
        if ($log->getOperacion() == $operacion) {
            return $this->render('FrontendBundle:Default:cambiarbobinasale.html.twig', array(
                'usuario'   => $usuario,
                'of'        => $of,
                'operacion' => $operacion,
                'log'       => $log,
                'error'     => 0
            ));
        } else {
            return $this->render('FrontendBundle:Default:cambiarbobina.html.twig', array(
                'usuario' => $usuario,
                'of' => $of,
                'log' => $log,
                'operacion' => $operacion,
                'error'=>2
            ));
        }
    }

    public function cambioBobinaSaleAction(Request $request) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $operacion = "";
        $log = "";
        $cambio = "111";
        $error=0;
        if ( $request->getMethod() == "POST" ) {
            $of = $request->request->get('of'); //gets POST var.
            $operacion = $request->request->get('operacion');
            $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));
            $postcomponente = $request->request->get('componente');

            $compo = explode("$", $postcomponente);

            if ( count($compo) < 3 ) {
                return $this->render('FrontendBundle:Default:cambiarbobinasale.html.twig', array(
                    'usuario'   => $usuario,
                    'of'        => $of,
                    'operacion' => $operacion,
                    'log'       => $log,
                    'error'     => 1
                ));
            } else {
                $componente = substr($compo[0], 1,strlen ($compo[0]));
                $lote = $compo[1];
                $cantidad = $compo[2];
                $uuid = $compo[3];

                // Comprobar que ese componente esta en LogDetail
                $sale = $em->getRepository('FrontendBundle:Logdetail')->findCheckdatamatrix($of,$operacion,$componente,$lote,$uuid);

                // Si está marcar salida
                if ( count($sale) > 0 ) {
                    $logcambio = new Logbobina();
                    $logcambio->setLog($log);
                    $logcambio->setOf($of);
                    $logcambio->setOperacion($operacion);
                    $logcambio->setComponenteSale($componente);
                    $logcambio->setLoteSale($lote);
//                $logcambio->setUsuario($usuario);
                    $logcambio->setUuidSale($uuid);
                    $em->persist(($logcambio));
                    $em->flush();

                    return $this->render('FrontendBundle:Default:cambiarbobinaentra.html.twig', array(
                        'usuario'   => $usuario,
                        'of'        => $of,
                        'operacion' => $operacion,
                        'log'       => $log,
                        'logcambio' => $logcambio,
                        'error'     => $error
                    ));


                } else {
                    return $this->render('FrontendBundle:Default:cambiarbobinasale.html.twig', array(
                        'usuario'   => $usuario,
                        'of'        => $of,
                        'operacion' => $operacion,
                        'log'       => $log,
                        'error'     => 1
                    ));
                }
            }

        }
    }

    /* CODIGO DATAMATRIX:
        R + 10/12 c + $ + LOTE + $ + cantidad + UUID
        EjemploS: R11TR1F0022$3813712832/PE268754C101$3000$4642
        R11TR1F0022$3813712832-PE268754C101$3000$4642
        R11TR1F0022$3813712832-PE268754C101$3000$4640
        R11TR1F0022$3813712832-PE268754C101$3000$4641
        R11TR1F0022$3813712832-PE268754C101$3000$4639
        R11TR1F0022$3813712832-PE268754C101$3000$4637
        R11TR1F0022$3813712832-PE268754C101$3000$4638
        R11di1f0014$3813712832-PE225495C301$3000$4617
        R11DI740005$3813712832-VD46BRG17$2500$4622
        R11TR1F0022$3813712832-PE268754C101$3000$4635
        R11TR1F0022$3813712832-PE268754C101$3000$4634
        R11TR1F0022$3813712832-PE268754C101$3000$4642
        */

    public function cambioBobinaEntraAction(Request $request) {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $operacion = "";
        $log = "";
        $error=0;

        if ( $request->getMethod() == "POST" ) {
            $of = $request->request->get('of'); //gets POST var.
            $operacion = $request->request->get('operacion');
            $postcomponente = $request->request->get('componente');
            $logcambioid = $request->request->get('logcambioid');

            $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion' => $operacion));
            $logcambio = $em->getRepository('FrontendBundle:Logbobina')->find($logcambioid);

            $compo = explode("$", $postcomponente);
            if ( count($compo) < 3 ) {
                return $this->render('FrontendBundle:Default:cambiarbobinaentra.html.twig', array(
                    'usuario'   => $usuario,
                    'of'        => $of,
                    'operacion' => $operacion,
                    'log'       => $log,
                    'logcambio' => $logcambio,
                    'error'     => 1
                ));
            } else {
                $componente = substr($compo[0], 1, strlen($compo[0]));
                $lote = $compo[1];
                $cantidad = $compo[2];
                $uuid = $compo[3];

                // Comprobar que ese componente esta en LogDetail
                $sale = $em->getRepository('FrontendBundle:Logdetail')->findCheckdatamatrix($of, $operacion, $componente, $lote, $uuid);

                // Si está marcar salida
                if (count($sale) == 0) {
                    $logcambio->setComponenteEntra($componente);
                    $logcambio->setLoteEntra($lote);
                    $logcambio->setUsuario($usuario);
                    $logcambio->setUuidEntra($uuid);
                    $em->persist(($logcambio));
                    $em->flush();

                    return $this->render('FrontendBundle:Default:cambiarbobinaresult.html.twig', array(
                        'usuario' => $usuario,
                        'of' => $of,
                        'operacion' => $operacion,
                        'log' => $log,
                        'logcambio' => $logcambio
                    ));


                } else {

                    // ERROR ES LA MISMA BOBINA
                    $error = 1;
                    return $this->render('FrontendBundle:Default:cambiarbobinaentra.html.twig', array(
                        'usuario' => $usuario,
                        'of' => $of,
                        'operacion' => $operacion,
                        'log' => $log,
                        'logcambio' => $logcambio,
                        'error' => $error,
                    ));
                }
            }
        }
    }
}
