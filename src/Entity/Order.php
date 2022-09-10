<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"order"})
     */
    private int $id;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, options={"default" : 0})
     * @Groups({"order"})
     */
    private float $subTotal;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, options={"default" : 0})
     * @Groups({"order"})
     */
    private float $total;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"order"})
     */
    private Customer $customer;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="order")
     * @Groups({"orderOrderProductRelation"})
     */
    private Collection $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity=OrderDiscountHistory::class, mappedBy="order")
     * @Groups({"orderOrderDiscountHistoryRelation"})
     */
    private Collection $orderDiscountHistory;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
        $this->orderDiscountHistory = new ArrayCollection();
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
    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     */
    public function setSubTotal(float $subTotal): void
    {
        $this->subTotal = $subTotal;
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
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    /**
     * @return Collection
     */
    public function getOrderDiscountHistory(): Collection
    {
        return $this->orderDiscountHistory;
    }

    /**
     * @param Collection $orderDiscountHistory
     */
    public function setOrderDiscountHistory(Collection $orderDiscountHistory): void
    {
        $this->orderDiscountHistory = $orderDiscountHistory;
    }
}
