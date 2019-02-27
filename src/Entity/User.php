<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
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
 *     "show",
 *     href=@Hateoas\Route(
 *     "show_user",
 *     parameters={ "id" = "expr(object.getId())"},
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
 *     "register",
 *     href=@Hateoas\Route(
 *     "register_user",
 *     absolute = true
 *     )
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     */
    private $email;

    /**
     * @ORM\Column(type="integer", length=255)
     * @Serializer\Expose()
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users")
     */
    private $client;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

}