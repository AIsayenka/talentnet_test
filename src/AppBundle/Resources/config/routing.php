<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('get_all', new Route('/api/products/all', array(
    '_controller' => 'AppBundle:ApiProductsController:get_all',
)));

$collection->add('get_one', new Route('/api/products/{id}', array(
    '_controller' => 'AppBundle:ApiProductsController:get_one',
)));

$collection->add('create_record', new Route('/api/products/create', array(
    '_controller' => 'AppBundle:ApiProductsController:create_record',
)));

$collection->add('update_record', new Route('/api/products/{id}/update', array(
    '_controller' => 'AppBundle:ApiProductsController:update_record',
)));

$collection->add('delete_record', new Route('/api/products/{id}/delete', array(
    '_controller' => 'AppBundle:ApiProductsController:delete_record',
)));

return $collection;