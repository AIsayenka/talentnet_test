<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class ApiAuthenticationController extends Controller
{

    function __construct() {
      // Needed to run a query to save the data
      //$manager = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/api/getToken")
     * @Method({"POST"})
     */
    public function getTokenAction()
    {
        // The security layer will intercept this request
        return new Response('', 401);
    }


}
