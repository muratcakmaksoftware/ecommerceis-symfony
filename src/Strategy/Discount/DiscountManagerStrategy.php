<?php

namespace App\Strategy\Discount;

use App\Entity\Cart;
use App\Enum\DiscountType;
use App\Helper\ArrayHelper;
use App\Interfaces\Strategy\Discount\DiscountStrategyInterface;
use App\Service\CartService;
use App\Service\DiscountService;
use Doctrine\Common\Collections\Collection;
use Exception;
use ReflectionException;

class DiscountManagerStrategy
{
    private DiscountStrategyInterface $strategy;

    private CartService $cartService;
    private DiscountService $discountService;
    private Cart $cart;
    private Collection $cartProducts;
    private array $discountMessages = [];
    private float $cartTotal; //Siparis toplami
    private array $discountTypes; //Hangi indirim yöntemi ile düşüş yapıldığının bilgisini almak için

    /**
     * @param CartService $cartService
     * @param DiscountService $discountService
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(CartService $cartService, DiscountService $discountService)
    {
        $this->setCartService($cartService);
        $this->setDiscountService($discountService);
        $this->setCart($this->getCartService()->getDefaultCart());
        $this->setCartProducts($this->getCart()->getCartProducts());
        $this->setCartTotal($this->getCart()->getTotal());
        $this->setDiscountTypes(ArrayHelper::getReflactionClassWithFlip(DiscountType::class));
    }

    /**
     * @param DiscountStrategyInterface $strategy
     * @return void
     */
    public function setStrategy(DiscountStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return void
     */
    public function runAlgorithm()
    {
        $this->strategy->runAlgorithm($this);
    }

    /**
     * @return array
     */
    public function getAnalysisResult(): array
    {
        return [
            'cart_id' => $this->getCart()->getId(),
            'discount' => $this->getDiscountMessages(),
            "total" => $this->getCartTotal()
        ];
    }

    /**
     * @param int $discountId
     * @param string $discountReason
     * @param float $discountAmount
     * @return void
     */
    public function addDiscountMessage(int $discountId, string $discountReason, float $discountAmount)
    {
        $this->discountMessages[$discountId] = [
            "discountReason" => $discountReason,
            "discountAmount" => $discountAmount,
            "subtotal" => round($this->getCartTotal() - $discountAmount, 2) //toplam fiyattan indirimin dusulmesi
        ];
    }

    /**
     * @return DiscountService
     */
    public function getDiscountService(): DiscountService
    {
        return $this->discountService;
    }

    /**
     * @param DiscountService $discountService
     */
    public function setDiscountService(DiscountService $discountService): void
    {
        $this->discountService = $discountService;
    }

    /**
     * @return array
     */
    public function getDiscountMessages(): array
    {
        return $this->discountMessages;
    }

    /**
     * @param array $discountMessages
     */
    public function setDiscountMessages(array $discountMessages): void
    {
        $this->discountMessages = $discountMessages;
    }

    /**
     * @return array
     */
    public function getDiscountTypes(): array
    {
        return $this->discountTypes;
    }

    /**
     * @param array $discountTypes
     */
    public function setDiscountTypes(array $discountTypes): void
    {
        $this->discountTypes = $discountTypes;
    }

    /**
     * @return CartService
     */
    public function getCartService(): CartService
    {
        return $this->cartService;
    }

    /**
     * @param CartService $cartService
     */
    public function setCartService(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
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

    /**
     * @return float
     */
    public function getCartTotal(): float
    {
        return $this->cartTotal;
    }

    /**
     * @param float $cartTotal
     */
    public function setCartTotal(float $cartTotal): void
    {
        $this->cartTotal = $cartTotal;
    }
}