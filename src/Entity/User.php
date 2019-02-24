<?php


namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "list_user",
 *     absolute = true
 *     )
 * )
 *@Hateoas\Relation(
 *     "login_check",
 *     href=@Hateoas\Route(
 *     "login_check",
 *     absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *     "delete_user",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "active_profile",
 *     href="expr('http://localhost:8000/active_profile_user')"
 *     )
 * )
 * @Hateoas\Relation(
 *     "register",
 *     href="expr('http://localhost:8000/register')"
 *     )
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}