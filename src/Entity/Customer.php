<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"customer"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer"})
     */
    private string $mail;

    /**
     * @ORM\Column(type="date")
     * @Groups({"customer"})
     */
    private DateTimeInterface $since;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, options={"default" : 0})
     * @Groups({"customer"})
     */
    private string $revenue;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     * @Groups({"customerOrderRelation"})
     */
    private Collection $orders;

    /**
     * @ORM\OneToMany(targetEntity=Cart::class, mappedBy="customer")
     * @Groups({"customerCartRelation"})
     */
    private Collection $carts;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSince(): DateTimeInterface
    {
        return $this->since;
    }

    /**
     * @param DateTimeInterface $since
     * @return $this
     */
    public function setSince(DateTimeInterface $since): self
    {
        $this->since = $since;

        return $this;
    }

    /**
     * @return string
     */
    public function getRevenue(): string
    {
        return $this->revenue;
    }

    /**
     * @param string $revenue
     * @return $this
     */
    public function setRevenue(string $revenue): self
    {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Collection $orders
     * @return void
     */
    public function setOrders(Collection $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return Collection
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    /**
     * @param Collection $carts
     */
    public function setCarts(Collection $carts): void
    {
        $this->carts = $carts;
    }
}
