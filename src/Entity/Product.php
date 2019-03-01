<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ExclusionPolicy("all")
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())")
 * )
 * @Hateoas\Relation(
 *     "list",
 *     href=@Hateoas\Route(
 *     "list_product",
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "show_product",
 *     parameters={ "id" = "expr(object.getId())"},
 *     absolute = true
 *     )
 * )
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose
     */
    private $productName;

    /**
     * @ORM\Column(type="integer")
     * @Expose
     */
    private $productPrice;

    /**
     * @ORM\Column(type="text")
     * @Expose
     */
    private $productDescription;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose
     */
    private $productBrand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductBrand(): ?string
    {
        return $this->productBrand;
    }

    public function setProductBrand(string $productBrand): self
    {
        $this->productBrand = $productBrand;

        return $this;
    }
}
