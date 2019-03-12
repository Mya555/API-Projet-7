<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
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
 */
class Client implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose()
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Serializer\Expose()
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=500)
     * @Serializer\Expose()
     */
    private $password;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client")
     */
    private $users;

    /**
     * Client constructor.
     * @param $username
     */
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

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_CLIENT');
    }

    public function eraseCredentials()
    {
    }
}