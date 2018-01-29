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

use AppBundle\Entity\Category;

class ApiCategoriesControllerController extends Controller
{
    private $manager;

    function __construct() {
      // Needed to run a query to save the data
      //$manager = $this->getDoctrine()->getManager();
    }
    /**
     * @Route("/api/categories/all", name="categories_list")
     * @Method({"GET"})
     */
    public function get_allAction()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $records = $repository->findAll();
        $data_array = array();

        // Creating array with all the data
        foreach($records as $item) {
             $data_array[] = array(
                 'id' => $item->getId(),
                 'name' => $item->getName(),
                 'created_at' => $item->getCreatedAt(),
                 'updated_at' => $item->getUpdatedAt(),
             );
        }

        $response = new JsonResponse($data_array);
        return $response;
        //return JsonResponse::create(["data" => "IAM WORKING"]);
    }

    /**
     * @Route("/api/categories/{id}", name="category_list")
     * @Method({"GET"})
     */
    public function get_oneAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Category::class);
        //$repository = $this->manager->getRepository(Product::class);
        $record = $repository->findOneById($id);

        if ($record) {
          $data_array = array(
            'id' => $record->getId(),
            'name' => $record->getName(),
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

}
