<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Product;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PagerFanta\Pagerfanta;
use App\Repository\ProductRepository;
use FOS\RestBundle\Request\ParamFetcherInterface;
use App\Representation\Products;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Swagger\Annotations as SWG;

class ClientController extends AbstractController
{

    /**
     * RETURNS THE AUTHENTICATED CLIENT'S USERNAME
     * @Rest\Post(
     *     path = "/api",
     *     name="current_client"
     * )
     * @Rest\View(statusCode=200)
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the name of the authenticated client",
     *     @SWG\Schema(ref=@Model(type=Client::class))
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Invalid Token",
     * )
     * @SWG\Response(
     *     response="404",
     *     description="User not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     * @return Response
     */
    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }

    /**
     * ADD A NEW CLIENT
     *
     * * @Rest\Post(
     *     path = "/register",
     *     name="add_client"
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Create client",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Invalid Token",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="client", ref=@Model(type=Client::class)))
     *)
     * @SWG\Tag(name="Clients")
     *
     * @Rest\View(statusCode= 201)
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        $client = new Client($username);
        $client->setPassword($encoder->encodePassword($client, $password));
        $em->persist($client);
        $em->flush();
        return new Response(sprintf('Client %s successfully created', $client->getUsername()));
    }
}