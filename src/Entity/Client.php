<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Table(name="clients")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *     "token",
 *     href=@Hateoas\Route(
 *     "login_check",
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "api",
 *     href=@Hateoas\Route(
 *     "api",
 *     absolute = true
 *     )
 * )
 */
class Client implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Expose
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=500)
     * @Expose
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client")
     */
    private $users;

    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
        return null;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getRoles()
    {
        return array('ROLE_CLIENT');
    }
    public function eraseCredentials()
    {
    }
}