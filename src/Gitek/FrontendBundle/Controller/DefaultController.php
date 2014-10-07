<?php

namespace Gitek\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Gitek\BackendBundle\Entity\Usuario;

class DefaultController extends Controller
{
    public function loginAction (Request $request)
    {
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

        $token = new UsernamePasswordToken($usuario, null, 'main', array('ROLE_USER'));
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));
        return $this->redirect($this->generateUrl('dashboard'));
    }

    public function dashboardAction() {

        $usuario = $this->getUser();

        return $this->render('FrontendBundle:Default:dashboard.html.twig', array(
            'usuario' => $usuario
        ));
    }

    public function logoutAction(){
        $this->get("request")->getSession()->invalidate();
        $this->get("security.context")->setToken(null);
        $this->get("session")->setFlash('message.success', true);
        return new RedirectResponse($this->generateUrl('login'));
    }
}
