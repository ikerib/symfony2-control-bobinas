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

}