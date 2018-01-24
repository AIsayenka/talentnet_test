<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiProductsControllerController extends Controller
{
    /**
     * @Route("/api/products/all")
     */
    public function get_allAction()
    {
        return $this->render('AppBundle:ApiProductsController:get.all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/api/products/{id}")
     */
    public function get_oneAction($id)
    {
        return $this->render('AppBundle:ApiProductsController:get.one.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/api/products/create")
     */
    public function create_recordAction()
    {
        return $this->render('AppBundle:ApiProductsController:create.record.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/api/products/{id}/update")
     */
    public function update_recordAction($id)
    {
        return $this->render('AppBundle:ApiProductsController:update.record.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/api/products/{id}/delete")
     */
    public function delete_recordAction($id)
    {
        return $this->render('AppBundle:ApiProductsController:delete.record.html.twig', array(
            // ...
        ));
    }

}
