<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MyShop\DefaultBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @TempLate
     */
    public function editAction(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($id);
        $form = $this->createForm(ProductType::class, $product);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                return $this->redirectToRoute("my_shop_admin.product_list");
            }
        }

        return [
            "form" => $form->createView(),
            "product" => $product
        ];

    }

    /**
     * @TempLate
     */
    public function deleteAction($id)
    {
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute("my_shop_admin.product_list");
    }

    public function listByCategoryAction($id_category)
    {
        $category = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->find($id_category);
        $productList = $category->getProductList();

        return $this->render("@MyShopAdmin/Product/list.html.twig", [
            "productList" => $productList
        ]);
    }

    /**
     * @TempLate()
     */
    public function listAction()
    {
        $productList = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->findAll();

        return ["productList" => $productList];
    }

	/**
	 * @Template()
	*/
	public function addAction(Request $request)
	{
		$product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                return $this->redirectToRoute("my_shop_admin.product_list");
            }
        }

        return [
            "form" => $form->createView()
        ];
	}
}