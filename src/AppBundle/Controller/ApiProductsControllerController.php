<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\Product;

class ApiProductsControllerController extends Controller
{
    function __construct() {
      // Needed to run a query to save the data
      //$manager = $this->getDoctrine()->getManager();
    }
    /**
     * @Route("/api/products/all", name="products_list")
     * @Method({"GET"})
     */
    public function get_allAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $records = $repository->findAll();
        $data_array = array();

        // Creating array with all the data
        foreach($records as $item) {
             $data_array[] = array(
                 'id' => $item->getId(),
                 'name' => $item->getName(),
                 'sku' => $item->getSku(),
                 'price' => $item->getPrice(),
                 'quantity' => $item->getQuantity(),
                 'created_at' => $item->getCreatedAt(),
                 'updated_at' => $item->getUpdatedAt(),
             );
        }

        $response = new JsonResponse($data_array);
        return $response;
        //return JsonResponse::create(["data" => "IAM WORKING"]);
    }

    /**
     * @Route("/api/products/{id}", name="product_list")
     * @Method({"GET"})
     */
    public function get_oneAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        //$repository = $this->manager->getRepository(Product::class);
        $record = $repository->findOneById($id);

        if ($record) {
          $data_array = array(
            'id' => $record->getId(),
            'name' => $record->getName(),
            'sku' => $record->getSku(),
            'price' => $record->getPrice(),
            'quantity' => $record->getQuantity(),
            'created_at' => $record->getCreatedAt(),
            'updated_at' => $record->getUpdatedAt(),
          );
        } else {
          $data_array = array(
            'data' => "There is no such record"
          );
        }

        $response = new JsonResponse($data_array);
        return $response;
    }

    /**
     * @Route("/api/products/create", name="create_product")
     * @Method({"POST"})
     */
    public function create_recordAction(Request $request)
    {
        //var_dump($request->get("name", ""));die();
        // Validation groups
        $validation_groups = [
          "name", "sku", "quantity", "price"
        ];

        // Needed to run a query to save the data
        $manager = $this->getDoctrine()->getManager();

        // Setting data
        $record = new Product();
        $record->setName($request->get("name", ""));
        $record->setSku($request->get("sku", ""));
        $record->setPrice($request->get("price", ""));
        $record->setQuantity($request->get("quantity", ""));
        $record->setCreatedAt(new \DateTime("now"));
        $record->setUpdatedAt(new \DateTime("now"));

        $validator = $this->get('validator');
        $errors = $validator->validate($record, null, $validation_groups);

        if(count($errors) > 0) {
          // if there is an error with validation
          $data_array = array(
            "data" => "The data input is incorrect. Error(s): ".(string) $errors
          );
          $manager->clear();
        } else { // if everything is fine
          // Set up the upcoming query to save the data
          $manager->persist($record);
          // Run the query
          $manager->flush();

          // Return updated record
          $data_array = array(
            'id' => $record->getId(),
            'name' => $record->getName(),
            'sku' => $record->getSku(),
            'price' => $record->getPrice(),
            'quantity' => $record->getQuantity(),
            'created_at' => $record->getCreatedAt(),
            'updated_at' => $record->getUpdatedAt(),
          );
        }

        $response = new JsonResponse($data_array);
        return $response;
    }

    /**
     * @Route("/api/products/{id}/update", name="update_product")
     * @Method({"PATCH", "PUT"})
     */
    public function update_recordAction($id, Request $request)
    {
        // Validation groups
        $validation_groups = [];
        // Needed to run a query to save the data
        $manager = $this->getDoctrine()->getManager();

        $record = $manager->getRepository(Product::class)->find($id);

        if (!$record) {
          $data_array = array(
            'data' => "There is no such record"
          );
          return new JsonResponse($data_array);
        }

        // Check of attributes
        // Name
        if($request->get("name") !== null && $request->get("name") !== $record->getName()) {
          $record->setName($request->get("name"));
          $validation_groups[] = "name";
        }

        // SKU
        if($request->get("sku") !== null && $request->get("sku") !== $record->getSku()) {
          $record->setSku($request->get("sku"));
          $validation_groups[] = "sku";
        }

        // Quantity
        if($request->get("quantity") !== null && $request->get("quantity") !== $record->getQuantity()) {
          $record->setQuantity(intval($request->get("quantity")));
          $validation_groups[] = "quantity";
        }

        // price
        if($request->get("price") !== null && $request->get("price") !== $record->getPrice()) {
          $record->setPrice(floatval($request->get("price")));
          $validation_groups[] = "price";
        }

        // Updating updated at
        $record->setUpdatedAt(new \DateTime("now"));

        $record = $manager->merge($record);

        $validator = $this->get('validator');
        $errors = $validator->validate($record, null, $validation_groups);

        if(count($errors) > 0) {
          // if there is an error with validation
          $data_array = array(
            "data" => "The data input is incorrect. Error(s): ".(string) $errors
          );
          $manager->clear();
        } else { // if everything is fine
          // Run the query
          $manager->flush();

          // Return updated record
          $data_array = array(
            'id' => $record->getId(),
            'name' => $record->getName(),
            'sku' => $record->getSku(),
            'price' => $record->getPrice(),
            'quantity' => $record->getQuantity(),
            'created_at' => $record->getCreatedAt(),
            'updated_at' => $record->getUpdatedAt(),
          );
        }

        $response = new JsonResponse($data_array);
        return $response;
    }

    /**
     * @Route("/api/products/{id}/delete", name="delete_product")
     * @Method({"DELETE"})
     */
    public function delete_recordAction($id)
    {

        // Needed to run a query to save the data
        $manager = $this->getDoctrine()->getManager();

        $record = $manager->getRepository(Product::class)->find($id);

        if (!$record) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $manager->remove($record);
        $manager->flush();

        $response = new JsonResponse(["data" => "The record was successfully deleted"]);
        return $response;
    }

}
