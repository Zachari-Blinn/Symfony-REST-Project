<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"order:read"}},
 *      denormalizationContext={"groups"={"order:write"}},
 *      collectionOperations={
 *          "delete"={
 *              "method"="delete",
 *              "path"="/orders",
 *              "controller"=App\Controller\RemoveAllOrder::class,
 *              "security"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("order:read")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("order:read")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("order:read")
     */
    private $creationDate;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="orders")
     * 
     * @Groups({"order:read", "order:write"})
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * 
     *
     * @Groups("article:read")
     */
    private $author;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->creationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
