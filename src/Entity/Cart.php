<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 * @ORM\Table(name="carts")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"cart"})
     */
    private int $id;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, options={"default" : 0})
     * @Groups({"cart"})
     */
    private float $total;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cart"})
     */
    private Customer $customer;

    /**
     * @ORM\OneToMany(targetEntity=CartProduct::class, mappedBy="cart", cascade={"remove"})
     * @Groups({"cartCartProductRelation"})
     */
    private Collection $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return $this
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    /**
     * @param Collection $cartProducts
     */
    public function setCartProducts(Collection $cartProducts): void
    {
        $this->cartProducts = $cartProducts;
    }
}
