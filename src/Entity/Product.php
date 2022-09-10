<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"product"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"productCategoryRelation"})
     */
    private Category $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product"})
     */
    private string $name;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, options={"default" : 0})
     * @Groups({"product"})
     */
    private float $price;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     * @Groups({"product"})
     */
    private int $stock;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="product")
     * @Groups({"productOrderProductRelation"})
     */
    private Collection $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity=CartProduct::class, mappedBy="product")
     * @Groups({"productCartProductRelation"})
     */
    private Collection $cartProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
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
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     * @return $this
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

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
     * @param Collection $orderProducts
     * @return void
     */
    public function setOrderProducts(Collection $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
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
     * @return void
     */
    public function setCartProducts(Collection $cartProducts): void
    {
        $this->cartProducts = $cartProducts;
    }
}
