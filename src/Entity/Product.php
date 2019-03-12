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
     * @Expose
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     * @return Product
     */
    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    /**
     * @param int $productPrice
     * @return Product
     */
    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    /**
     * @param string $productDescription
     * @return Product
     */
    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductBrand(): ?string
    {
        return $this->productBrand;
    }

    /**
     * @param string $productBrand
     * @return Product
     */
    public function setProductBrand(string $productBrand): self
    {
        $this->productBrand = $productBrand;

        return $this;
    }
}
