<?php

namespace MyShop\DefaultBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MyShop\DefaultBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Bundle\FrameworkBundle\Controller\redirectToRoute;

class DefaultController extends Controller
{
	/**
	 * @Template()
 	*/
    public function indexAction()
    {
        return [
            "newsList" => '...',
            "productList" => '...'
        ];
    }

    public function createSomeProductAction()
    {
    	$product = new Product();
    	$product->setModel("J5");
    	$product->setPrice(200);
    	$product->setDescription("Great mobile phone!");

    	$manager = $this->getDoctrine()->getManager();
    	$manager->persist($product);
    	$manager->flush();

    	$response = new Response();
    	$response->setContent($product->getId());
    	return $response;
    }

 	/**
	 * @Template()
 	*/
    public function showProductAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository("MyShopDefaultBundle:Product");
        $product = $repository->find($id);

        return [
            "product" => $product
        ];
    }


    /**
	 * @Template()
 	*/
    public function showProductListAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository("MyShopDefaultBundle:Product");

        $productList = $repository->findAll();

        return [
        	"productList" => $productList
        ];
    }
}
