<?php

namespace App\Controller;

use App\Entity\Product;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PagerFanta\Pagerfanta;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;

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
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
     *     nullable=true,
     *     description="Le mot clé a chercher."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Ordre croissant ou décroissant"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="10",
     *     description="Le nombre maximale de produit par page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="L'index de l'élément par lequel on commence"
     * )
     * @Rest\View
     * @param ParamFetcherInterface $paramFetcher
     * @return
     */
    public function listProduct(ParamFetcherInterface $paramFetcher){
        //$product = $this->getDoctrine()->getRepository(Product::class)->findAll();
        //return $product;
        $pager = $this->getDoctrine()->getRepository(Product::class)->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
        return $pager->getCurrentPageResults();
    }
}
