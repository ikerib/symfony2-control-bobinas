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
use Gitek\FrontendBundle\Entity\Logdetail;

class ApiController extends FOSRestController
{

    /**
     * @Rest\View
     */
    public function postLogprogramaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $logid = $request->request->get('logid');
        $programa = $request->request->get('programa');


        $log = $em->getRepository('FrontendBundle:Log')->find($logid);

        if ((!$log) || (count($log)==0)) {
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        } else {
            $log->setPrograma($programa);
            $em->persist($log);
            $em->flush();
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        }
    }

    /**
     * @Rest\View
     */
    public function postAoipatronAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $milogid = $request->request->get('logid');

        $log = $em->getRepository('FrontendBundle:Log')->find($milogid);

        if (!$log) {
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        } else {
            if ( $log->getAoipatron() == 1 ) {
                $log->setAoipatron(0);
            } else {
                $log->setAoipatron(1);
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
    public function postCheckpickplaceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postcomponente = $request->request->get('componente');
        $compo = explode("$", $postcomponente);

        if ( count($compo) >1 ) {
            $componente = substr($compo[0], 1,strlen ($compo[0]));
            $lote = $compo[1];
            $cantidad = $compo[2];
            $uuid = $compo[3];
        } else {
            if ( $postcomponente == "" ) {
                $response = new Response();
                $response->setStatusCode(204);
                return $response;
            }
            $componente = $postcomponente;
            $lote = "";
            $cantidad = "";
            $uuid = "";
        }
        $posicion = $request->request->get('posicion');
        $operacion = $request->request->get('operacion');

        $aux = $em->getRepository('BackendBundle:AuxSiplace')->fincComponente($componente, $posicion);

        if ((!$aux) || (count($aux)==0)) {
            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        } else {
            $log = $em->getRepository('FrontendBundle:Log')->findOneByOperacion(array('operacion'=>$operacion));

            foreach ($log->getDetalles() as $d) {
                if ( $d->getComponente() == $componente) {
                    $d->setPickplace(1);
                    $em->persist($d);
                    $em->flush();
                    $statusCode = 200;
                    $view = $this->view($aux, $statusCode);
                    return $this->handleView($view);
                }
            }

            $statusCode = 204;
            $view = $this->view($statusCode);
            return $this->handleView($view);
        }
    }


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
    public function  getSerigrafiaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ValidacionSerigrafia')->findSerigrafiaVisible();
        $statusCode = 200;
        $view = $this->view($entities, $statusCode);
        return $this->handleView($view);
    }

}