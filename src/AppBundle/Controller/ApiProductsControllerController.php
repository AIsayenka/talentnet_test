<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class ApiProductsControllerController extends Controller
{
    private $manager;

    function __construct() {
      // Needed to run a query to save the data
      $manager = $this->getDoctrine()->getManager();
    }
    /**
     * @Route("/api/products/all")
     */
    public function get_allAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        //$repository = $this->manager->getRepository(Product::class);
        $records = $repository->findAll();

        $response = new JsonResponse($records);
        return $response;
    }

    /**
     * @Route("/api/products/{id}")
     */
    public function get_oneAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        //$repository = $this->manager->getRepository(Product::class);
        $record = $repository->findOneById($id);

        $response = new JsonResponse($record);
        return $response;
    }

    /**
     * @Route("/api/products/create")
     */
    public function create_recordAction()
    {
        // Setting data
        $record = new Product();
        $record->setName("");
        $record->setName("");
        $record->setName("");

        // Set up the upcoming query to save the data
        $this->manager->persist($record);

        // Run the query
        $this->manager->flush();

        $response = new JsonResponse($records);
        return $response;
    }

    /**
     * @Route("/api/products/{id}/update")
     */
    public function update_recordAction($id)
    {
        $record = $this->manager->getRepository(Product::class)->find($id);

        if (!$record) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // TODO check for attributes in the request and update them appropriately

        // Run the query
        $this->manager->flush();

        $response = new JsonResponse($record);
        return $response;
    }

    /**
     * @Route("/api/products/{id}/delete")
     */
    public function delete_recordAction($id)
    {
        $record = $this->manager->getRepository(Product::class)->find($id);

        if (!$record) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $this->manager->remove($record);
        $this->manager->flush();

        $response = new JsonResponse($records);
        return $response;
    }

}
