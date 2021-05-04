<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"product:read"}},
 *      denormalizationContext={"groups"={"product:write"}},
 *      collectionOperations={
 *          "get", "post"
 *      },
 *      itemOperations={
 *          "get",
 *          "put",
 *          "patch",
 *      },
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("product:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Groups({"product:read", "product:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"product:read", "product:write"})
     */
    private $photo;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups({"product:read", "product:write"})
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="products", cascade="persist")
     * 
     * @Groups({"product:read", "product:write"})
     */
    private $orders;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Groups({"product:read", "product:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Cart::class, mappedBy="product")
     */
    private $carts;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removeProduct($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->addProduct($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            $cart->removeProduct($this);
        }

        return $this;
    }
}
