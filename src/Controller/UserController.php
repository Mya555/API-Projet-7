<?php
namespace App\Controller;
use App\Entity\Client;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Representation\Users;
use App\Entity\Product;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PagerFanta\Pagerfanta;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
/**
 * @property TokenStorageInterface tokenStorage
 */
class UserController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;


    /**
     * UserController constructor.
     * @param EntityManagerInterface $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $manager, TokenStorageInterface $tokenStorage)
    {
        $this->manager = $manager;
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * ADD A NEW USER
     *
     * @Rest\Post(
     *     path = "/add_user",
     *     name="add_user"
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Create user",
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
     *     name="Authorization",
     *     in="header",
     *     default="Bearer Token",
     *     description="Bearer {your access token}",
     *     required=true,
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(type="object",
     *          @SWG\Property(property="user", ref=@Model(type=User::class)))
     *)
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
     * @Rest\View(statusCode=201)
     * @param Request $request
     * @return Response
     */
    public function addUser(Request $request){
        $user = new User();
        $user->setFirstName($request->get('firstName'))
            ->setLastName($request->get('lastName'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setClient($this->tokenStorage->getToken()->getUser());
        $this->manager->persist($user);
        $this->manager->flush();
        return new Response(sprintf('Client %s successfully created', $user->getFirstName()));
    }

    /**
     * DETAILS OF THE SELECTED USER
     *
     * @Rest\Get(
     *     path = "/show_user/{id}",
     *     name="show_user",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(statusCode= 200)
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the details of the selected user",
     *     @SWG\Schema(ref=@Model(type=User::class))
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
     *     name="id",
     *     in="path",
     *     description="The user's id",
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
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
     * @Cache(expires="tomorrow", public=true)
     * @param User $user
     * @return User
     */
    public function showUser(User $user)
    {
        return $user;
    }

    /**
     * USERS LIST
     *
     * @Rest\Get("/list_user", name="list_user")
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
     *     description="Returns the list of users",
     *     @SWG\Schema(ref=@Model(type=User::class)),
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
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
     * @Cache(expires="tomorrow", public=true)
     * @param ParamFetcherInterface $paramFetcher
     * @return Users
     */
    public function listUser(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository( User::class )->search(
            $paramFetcher->get( 'keyword' ),
            $paramFetcher->get( 'order' ),
            $paramFetcher->get( 'limit' ),
            $paramFetcher->get( 'offset' )
        );
        return new Users( $pager );
    }

    /**
     * DELETING THE USER
     *
     * @Rest\Delete(
     *     path="/delete_user/{id}",
     *     name="delete_user",
     *     requirements={"id" = "\d+"}
     *     )
     * @SWG\Response(
     *     response=204,
     *     description="Delete selected user",
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Invalid Token",
     * )
     * @SWG\Response(
     *     response="400",
     *     description="A violation is raised by validation",
     * )
     * @SWG\Response(
     *     response="404",
     *     description="User not found or does not exist",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The user id.",
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
     * @SWG\Tag(name="Users")
     * @Security(name="Bearer")
     * @param User $user
     * @Rest\View(statusCode= 204)
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove( $user );
        $em->flush();
        return;
    }
}