<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="order_discount_history")
 */
class OrderDiscountHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"orderDiscountHistory"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="id")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"orderDiscountHistoryOrderRelation"})
     */
    private Order $order;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"orderDiscountHistory"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     * @Groups({"orderDiscountHistory"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"orderDiscountHistory"})
     */
    private string $jsonData;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return $this->jsonData;
    }

    /**
     * @param string $jsonData
     */
    public function setJsonData(string $jsonData): void
    {
        $this->jsonData = $jsonData;
    }
}
