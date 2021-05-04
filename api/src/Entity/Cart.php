<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get",
 *          "validate_cart"={
 *              "method"="GET",
 *              "path"="/cart/validate",
 *              "controller"=App\Controller\ValidateCart::class,
 *              "read"=false,
 *              "security"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          },
 *      },
 *      itemOperations={
 *          "get",
 *          "put",
 *          "patch",
 *          "add_product"={
 *              "method"="POST",
 *              "input"=false,
 *              "path"="/cart/{id}",
 *              "controller"=App\Controller\AddProduct::class,
 *              "read"=false,
 *              "security"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          },
 *          "remove_product"={
 *              "method"="DELETE",
 *              "path"="/cart/{id}",
 *              "controller"=App\Controller\RemoveProduct::class,
 *              "read"=false,
 *              "security"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          },
 *      },
 *  )
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="cart", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="carts")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }
}
