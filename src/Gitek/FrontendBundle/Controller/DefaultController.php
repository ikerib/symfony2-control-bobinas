<?php

namespace Gitek\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Gitek\BackendBundle\Entity\Usuario;


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

    public function logincheckAction(Request $request)
    {
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

    public function dashboardAction() {

        $usuario = $this->getUser();
        $of='';
        $operacion = '';

        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion
        ));
    }

    public function fase2Action() {

        $usuario = $this->getUser();

        return $this->render('FrontendBundle:Default:fase2.html.twig', array(
            'usuario' => $usuario
        ));
    }

    public function logoutAction(){
        $this->get("request")->getSession()->invalidate();
        $this->get("security.context")->setToken(null);
        $this->get("session")->setFlash('message.success', true);
        return new RedirectResponse($this->generateUrl('login'));
    }

    public function findofAction(Request $request,$of=null) {
        if ( $request->getMethod() == "POST" ) {
            $of = $request->request->get('of'); //gets POST var.
            return $this->redirect($this->generateUrl("find_of", array( 'of' => $of) ));
        }

        $client = $this->get('guzzle.client');
        $request = $client->get('http://10.0.0.12:5080/expertis/delaoferta?of=' . $of);
        $response = $request->send();
        $data = $response->json();

        if ( !count($data) > 0 ) {
            $of = "no encontrado";
        }

        $usuario = $this->getUser();
        $operacion = "";


        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion
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

        // Info de los componentes
        $request = $client->get('http://10.0.0.12:5080/expertis/poroperacion?operacion=' . $operacion);
        $response = $request->send();
        $componentes = $response->json();


        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario,
            'of' => $of,
            'operacion' => $operacion,
            'componentes' => $componentes

        ));

    }

}
