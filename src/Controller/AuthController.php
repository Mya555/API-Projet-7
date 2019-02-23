<?php

namespace App\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use App\Representation\Users;
use App\Entity\Product;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PagerFanta\Pagerfanta;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;


class AuthController extends AbstractController
{
    /**
     * @Rest\Get("/user_list", name="user_list")
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
     * @Rest\View()
     * @param ParamFetcherInterface $paramFetcher
     * @return Users
     */
    public function listUser(ParamFetcherInterface $paramFetcher){

        $pager = $this->getDoctrine()->getRepository(User::class)->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
        return new Users($pager);
    }

    /**
     * @Rest\Delete(
     *     path="/delete_user/{id}",
     *     name="user_delete",
     *     requirements={"id" = "\d+"}
     *     )
     * @param User $user
     * @Rest\View(statusCode= 204)
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return;
    }

}