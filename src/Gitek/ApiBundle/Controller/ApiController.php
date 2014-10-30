<?php

namespace Gitek\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Gitek\BackendBundle\Entity\ValidacionSerigrafia;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

class ApiController extends FOSRestController
{
    /**
     * @Rest\View
     */
    public function getOrdenAction($id)
    {
        $statusCode = 200;
        $entity = array('id' => 'OF212042');
        $view = $this->view($entity, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\View
     */
    public function getOperacionAction($id)
    {
        $statusCode = 200;
        $entity = array('operacion' => 'SMD CARA TOP');
        $view = $this->view($entity, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\View
     */
    public function  getSerigrafiaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ValidacionSerigrafia')->findSerigrafiaVisible();
        $statusCode = 200;
        $view = $this->view($entities, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\View
     */
    public function  getPushnotifyAction()
    {
        $message = new AndroidMessage();
        $message->setGCM(true);
        $message->setMessage('Oh my! A push notification!');
        $this->container->get('rms_push_notifications')->send($message);

        return new Response('Push notification send!');
    }

}