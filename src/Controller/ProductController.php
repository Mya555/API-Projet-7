<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Rest\Get(
     *     path = "/product/{id}",
     *     name="show_product",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @param Product $product
     * @return Product
     */
    public function showProduct(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\Get("/product", name="list_product")
     * @Rest\View
     */
    public function listProduct(){
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $product;
    }
}
