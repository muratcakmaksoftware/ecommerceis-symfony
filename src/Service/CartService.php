<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Repository\CartRepository;
use Exception;
use ReflectionException;
use Symfony\Component\Serializer\SerializerInterface;

class CartService extends BaseService
{
    private ProductService $productService;
    private CustomerService $customerService;
    private ?Cart $cart;

    /**
     * @throws Exception
     */
    public function __construct(CartRepository $repository, SerializerInterface $serializer,
                                ProductService $productService, CustomerService $customerService)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;

        $this->productService = $productService;
        $this->customerService = $customerService;
        $this->em = $this->repository->getEntityManager();
        $this->cart = $this->getCart(['customer' => $this->customerService->getCustomerTest()], null, false);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return Cart|null
     * @throws Exception
     */
    public function getCart(array $criteria, array $orderBy = null, bool $notFoundException = true): ?Cart
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return Cart[]
     */
    public function getCartBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Müşterinin sepetindeki tüm ürün bilgilerini döner.
     * @return mixed
     * @throws Exception
     */
    public function index()
    {
        return json_decode($this->serializer->serialize($this->getDefaultCart(), 'json', [
            'groups' => ['cart', 'cartCartProductRelation', 'cartProduct']
        ]));
    }

    /**
     * Müşteriye ait default sepet kaydını döner.
     * @return Cart
     * @throws Exception
     */
    public function getDefaultCart(): Cart
    {
        if (is_null($this->cart)) {
            $this->cart = $this->store([
                'total' => 0,
                'customer' => $this->customerService->getCustomerTest()
            ]);
        }
        return $this->cart;
    }

    /**
     * Sepete ürün eklendiğinde, ürün bilgisine göre sepet totalinin artırır.
     * @param CartProduct $cartProduct
     * @return void
     */
    public function updateCartTotalByAddCartProduct(CartProduct $cartProduct): void
    {
        $cart = $cartProduct->getCart();
        $this->update($cart, [
            'total' => ($cart->getTotal() + $cartProduct->getTotal())
        ]);
    }

    /**
     * Sepetdeki ürün güncellendiğinde, ürün bilgisine göre sepet totalinin günceller.
     * @param CartProduct $cartProduct
     * @param int $quantity
     * @return void
     */
    public function updateCartTotalByUpdateCartProduct(CartProduct $cartProduct, int $quantity): void
    {
        $cart = $cartProduct->getCart();
        $product = $cartProduct->getProduct();
        $total = $cart->getTotal() - $cartProduct->getTotal();
        $total = $total + $this->productService->getTotalQuantityPriceByProduct($product, $quantity);
        $this->update($cart, [
            'total' => $total
        ]);
    }

    /**
     * Sepetdeki ürün silindiğinde, ürün bilgisine göre sepet totalini günceller.
     * @param CartProduct $cartProduct
     * @return void
     */
    public function updateCartTotalByDestroyCartProduct(CartProduct $cartProduct): void
    {
        $cart = $cartProduct->getCart();
        $this->update($cart, [
            'total' => $cart->getTotal() - $cartProduct->getTotal()
        ]);
    }
}