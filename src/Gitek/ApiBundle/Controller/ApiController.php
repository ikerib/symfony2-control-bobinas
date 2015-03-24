<?php

namespace Gitek\ApiBundle\Controller;

use Gitek\FrontendBundle\Entity\LogPickplace;
use Gitek\FrontendBundle\Entity\LogSerigrafia;
use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Gitek\BackendBundle\Entity\ValidacionSerigrafia;
use Gitek\BackendBundle\Entity\Usuario;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

class ApiController extends FOSRestController
{

    /**
     * @Rest\View
     */
    public function postValidate5Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $milogid = $request->request->get('logid');

        $log = $em->getRepository('FrontendBundle:Log')->find($milogid);

        if (!$log) {
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        } else {
            if ( $log->getValidacion5() == 1 ) {
                $log->setValidacion5(0);
            } else {
                $log->setValidacion5(1);
            }
            $em->persist($log);
            $em->flush();
            $statusCode = 200;
            $view = $this->view($log, $statusCode);
            return $this->handleView($view);
        }
    }

    /**
     * @Rest\View
     */
    public function postValidate4Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $milogid = $request->request->get('logid');

        $log = $em->getRepository('FrontendBundle:Log')->find($milogid);

        if (!$log) {
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        } else {
            if ( $log->getValidacion4() == 1 ) {
                $log->setValidacion4(0);
            } else {
                $log->setValidacion4(1);
            }
            $em->persist($log);
            $em->flush();
            $statusCode = 200;
            $view = $this->view($log, $statusCode);
            return $this->handleView($view);
        }
    }


    /**
    * @Rest\View
    */
    public function postValidate1questionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->request->get('q');
        $milogid = $request->request->get('logid');
        $milogserigrafiaid = $request->request->get('logserigrafiaid');

        $question = $em->getRepository('BackendBundle:ValidacionSerigrafia')->find($q);
        $log = $em->getRepository('FrontendBundle:Log')->find($milogid);

        if (!$question) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        if (!$milogserigrafiaid) {
            $logserigrafia = new LogSerigrafia();
            $logserigrafia->setLog($log);
            $logserigrafia->setPregunta($question);
            $logserigrafia->setRespuesta(1);
            $em->persist($logserigrafia);
            $em->flush();
        } else {
            $logserigrafia = $em->getRepository('FrontendBundle:LogSerigrafia')->find($milogserigrafiaid);
            if ( $logserigrafia->getRespuesta() == 0 )
            {
                $logserigrafia->setRespuesta(1);
            } else {
                $logserigrafia->setRespuesta(0);
            }
            $em->persist($logserigrafia);
            $em->flush();
        }


        $statusCode = 200;
        $view = $this->view($logserigrafia, $statusCode);
        return $this->handleView($view);

    }

    public function postValidate2questionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->request->get('q');
        $milogid = $request->request->get('logid');
        $milogpickplaceid = $request->request->get('logpickplaceid');

        $question = $em->getRepository('BackendBundle:ValidacionPickPlace')->find($q);
        $log = $em->getRepository('FrontendBundle:Log')->find($milogid);

        if (!$question) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        if (!$milogpickplaceid) {
            $logpickplace = new LogPickplace();
            $logpickplace->setLog($log);
            $logpickplace->setPregunta($question);
            $logpickplace->setRespuesta(1);
            $em->persist($logpickplace);
            $em->flush();
        } else {
            $logpickplace = $em->getRepository('FrontendBundle:LogPickplace')->find($milogpickplaceid);
            if ( $logpickplace->getRespuesta() == 0 )
            {
                $logpickplace->setRespuesta(1);
            } else {
                $logpickplace->setRespuesta(0);
            }
            $em->persist($logpickplace);
            $em->flush();
        }


        $statusCode = 200;
        $view = $this->view($logpickplace, $statusCode);
        return $this->handleView($view);

    }


    /**
     * @Rest\View
     */
    public function getComponentesAction($operacion)
    {
        $statusCode = 200;

        $client = $this->get('guzzle.client');
        $request = $client->get('http://10.0.0.12:5080/expertis/poroperacion?operacion=' . $operacion);
        $response = $request->send();
        $componentes = $response->json();

        $view = $this->view($componentes, $statusCode);
        return $this->handleView($view);
    }

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

    public function sendEmailAction() {
        $message = \Swift_Message::newInstance()
            ->setSubject('Código: 123')
            ->setFrom('planificacion@gureak.com')
            ->setTo('ikerib@gmail.com')
            ->setBody("");
        $resp = $this->get('mailer')->send($message);
        $statusCode = 200;
        $view = $this->view($resp, $statusCode);
        return $this->handleView($view);
    }

    /**
     * Collection post action
     * @var Request $request
     * @return View|array
     */
    public function postRegisterphoneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $androidid = $request->request->get('androidid');
        $androiduser = $request->request->get('androiduser');
        $user = $em->getRepository('BackendBundle:Usuario')->findOneBy(array('nombre' => $androiduser ));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        if ($androidid) {
            $user->setAndroidreg($androidid);
            $user->setUpdated(new \DateTime());
            $em->flush();
        }

        $statusCode = 200;
        $view = $this->view($user, $statusCode);
        return $this->handleView($view);
    }


}