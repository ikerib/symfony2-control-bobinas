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
use Gitek\BackendBundle\Entity\Usuario;
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

    /**
     * @Rest\View
     */
    public function  getPushnotifyAction()
    {
//        $message = new AndroidMessage();
//        $message->setGCM(true);
//        $message->setDeviceIdentifier('APA91bE2-uEWNIw91WT5yCw8YQKS_57clEKeNixzR_adBQxGp-0Ps0y5Mj6K5trbDj0JWI-rNSju03E9RKfSCLH59Qhn2aCoMZgdLtWo99qz67XyKpjtAu35ACMO_7LYIRJTp_Y4Sw5AGxkxStnHYthNKrNpZntvNk1ysfzXjt4OSFi3VjzOWyY');
//        $message->setMessage('Oh my! A push notification!');
//        $this->container->get('rms_push_notifications')->send($message);
//
//        return new Response('Push notification send!');
        // $data = array( 'message' => 'Hello World!' );
        // $ids = '';

        // $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=AIzaSyDODAwhOPWdyW_ekUBWfFNEOa429RN-teU");
        // $data = array(
        //     'data' => $data,
        //     'registration_ids' => "['APA91bE2-uEWNIw91WT5yCw8YQKS_57clEKeNixzR_adBQxGp-0Ps0y5Mj6K5trbDj0JWI-rNSju03E9RKfSCLH59Qhn2aCoMZgdLtWo99qz67XyKpjtAu35ACMO_7LYIRJTp_Y4Sw5AGxkxStnHYthNKrNpZntvNk1ysfzXjt4OSFi3VjzOWyY']"
        // );

        // $ch = curl_init();

        // curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        // curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
        // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

        // $response = curl_exec($ch);
        // curl_close($ch);

        // return $response;

        // Set POST variables
//        $url = 'https://android.googleapis.com/gcm/send';
//        $registatoin_ids = array('APA91bE2-uEWNIw91WT5yCw8YQKS_57clEKeNixzR_adBQxGp-0Ps0y5Mj6K5trbDj0JWI-rNSju03E9RKfSCLH59Qhn2aCoMZgdLtWo99qz67XyKpjtAu35ACMO_7LYIRJTp_Y4Sw5AGxkxStnHYthNKrNpZntvNk1ysfzXjt4OSFi3VjzOWyY');
//        $message = array("title" => "AUPA HI!!!", "message" >= "KAIXOOOOOOOOO!");
//        $fields = array(
//            'registration_ids' => $registatoin_ids,
//            'data' => $message,
//        );
//
//        $headers = array(
//            'Authorization: key=AIzaSyDODAwhOPWdyW_ekUBWfFNEOa429RN-teU',
//            'Content-Type: application/json'
//        );
//        //print_r($headers);
//        // Open connection
//        $ch = curl_init();
//
//        // Set the url, number of POST vars, POST data
//        curl_setopt($ch, CURLOPT_URL, $url);
//
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        // Disabling SSL Certificate support temporarly
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//
//        // Execute post
//        $result = curl_exec($ch);
//        if ($result === FALSE) {
//            die('Curl failed: ' . curl_error($ch));
//        }
//
//        // Close connection
//        curl_close($ch);

        $api_key = "AIzaSyDODAwhOPWdyW_ekUBWfFNEOa429RN-teU";
        $name = 'iker';
        $deal = 'deal';
        $valid = 'valid';
        $address = 'address';

        // please enter the registration id of the device on which you want to send the message
        $registrationIDs= array("APA91bE2-uEWNIw91WT5yCw8YQKS_57clEKeNixzR_adBQxGp-0Ps0y5Mj6K5trbDj0JWI-rNSju03E9RKfSCLH59Qhn2aCoMZgdLtWo99qz67XyKpjtAu35ACMO_7LYIRJTp_Y4Sw5AGxkxStnHYthNKrNpZntvNk1ysfzXjt4OSFi3VjzOWyY");
        $message = array("name" => $name, "deal" => $deal, "valid" => $valid, "address" => $address);
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids'  => $registrationIDs,
            'data'              => array( "message" => $message ),
        );

        $headers = array(
            'Authorization: key=' . $api_key,
            'Content-Type: application/json');



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }

}