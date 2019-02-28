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
    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
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