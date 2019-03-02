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
use App\Representation\Products;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;


class ProductController extends AbstractController
{
    /**
     * DETAILS OF THE SELECTED PRODUCT
     *
     * @Rest\Get(
     *     path = "/show_product/{id}",
     *     name="show_product",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the selected product",
     *     @SWG\Schema(ref=@Model(type=Product::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Invalid Token",
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Product not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The product id.",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     * @Rest\View(statusCode= 200)
     * @param Product $product
     * @return Product
     */
    public function showProduct(Product $product)
    {
        return $product;
    }

    /**
     * PRODUCTS LIST
     *
     * @Rest\Get("/list_product",
     *          name="list_product")
     *
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
     *     nullable=true,
     *     description="The key word to look for"
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Ascending or descending order"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="10",
     *     description="The maximum number of products per page"
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The index of the element by which to start"
     * )
     * @Rest\View(statusCode= 200)
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of products",
     *     @SWG\Schema(ref=@Model(type=Product::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Invalid Token",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     * @param ParamFetcherInterface $paramFetcher
     * @return Products
     */
    public function listProduct(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository( Product::class )->search(
            $paramFetcher->get( 'keyword' ),
            $paramFetcher->get( 'order' ),
            $paramFetcher->get( 'limit' ),
            $paramFetcher->get( 'offset' )
        );
        return new Products( $pager );
    }
}
