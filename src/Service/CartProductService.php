<?php

namespace App\Service;

use App\Entity\CartProduct;
use App\Entity\Product;
use App\Repository\CartProductRepository;
use Exception;

class CartProductService extends BaseService
{
    private CartService $cartService;
    private ProductService $productService;

    public function __construct(CartProductRepository $repository, CartService $cartService, ProductService $productService)
    {
        $this->repository = $repository;
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->em = $this->repository->getEntityManager();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return CartProduct|null
     * @throws Exception
     */
    public function getCartProduct(array $criteria, array $orderBy = null, bool $notFoundException = true): ?CartProduct
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return CartProduct[]
     */
    public function getCartProductBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param int $productId
     * @return CartProduct|null
     * @throws Exception
     */
    public function getCartProductByCartIdAndProductId(int $productId): ?CartProduct
    {
        $cart = $this->cartService->getDefaultCart();
        return $this->getCartProduct([
            'cart' => $cart->getId(),
            'product' => $productId
        ], null, false);
    }

    /**
     * Sepete ürünü ekler
     * @param array $attributes
     * @return void
     */
    public function storeCartProduct(array $attributes): void
    {
        $this->em->transactional(function () use ($attributes) {
            $cartProduct = $this->getCartProductByCartIdAndProductId($attributes['product_id']); //CartProduct'ı cartId ve productId göre çekilmesi.
            if (is_null($cartProduct)) { //Aynı ürün daha önceden eklenmediyse ekleme yapılır.
                $product = $this->productService->getProduct(['id' => $attributes['product_id']]); // ürün mevcut mu ve ürün bilgisini getirme
                $cartProduct = $this->addCartProduct($product, $attributes['quantity']); //ürünü siparişe kaydet
                $this->cartService->updateCartTotalByAddCartProduct($cartProduct); //eklemeye göre sipariş totalini günceller.
            } else { //ürün daha önce eklenmiş ve tekrar aynı ürünü ekleme yaptığı için adet güncellemesi yapılır.
                $attributes["quantity"] = $cartProduct->getQuantity() + $attributes["quantity"];
                $this->updateCartProductPart($attributes, $cartProduct); //güncelleme için gerekli işlemler yapılır.
            }
        });
    }

    /**
     * Sepetdeki ürünü günceller
     * @param array $attributes
     * @param int $cartProductId
     * @return void
     */
    public function updateCartProduct(array $attributes, int $cartProductId): void
    {
        $this->em->transactional(function () use ($attributes, $cartProductId) {
            $cartProduct = $this->getCartProduct(['id' => $cartProductId]); // CartProduct mevcut mu ?
            $this->updateCartProductPart($attributes, $cartProduct); //CartProduct mevcutsa güncelleme yapılır
        });
    }

    /**
     * Sepete ait ürün ile ilgili güncelleme işlemlerini gerçekleştirir.
     * @param array $attributes
     * @param CartProduct $cartProduct
     * @return void
     * @throws Exception
     */
    public function updateCartProductPart(array $attributes, CartProduct $cartProduct): void
    {
        $product = $cartProduct->getProduct(); //ürün bilgiler ulaş
        $this->productService->checkStockQuantityByProduct($product, $attributes['quantity']); //ürün stoğunu kontrol et.

        $this->cartService->updateCartTotalByUpdateCartProduct($cartProduct, $attributes['quantity']); //sipariş total inde önceki kayıttaki ürün totalini çıkar ve yeni ürün totalini güncelle.
        $this->update($cartProduct, [ //CartProduct bilgilerini güncellenen ürün bilgilerine göre güncelle.
            'quantity' => $attributes['quantity'],
            'unitPrice' => $product->getPrice(),
            'total' => $this->productService->getTotalQuantityPriceByProduct($product, $attributes['quantity'])
        ]);
    }

    /**
     * Sepetden ürünü kaldırır.
     * @param $cartProductId
     * @return void
     */
    public function destroyCartProduct($cartProductId)
    {
        $this->em->transactional(function () use ($cartProductId) {
            $cartProduct = $this->getCartProduct(['id' => $cartProductId]); //CartProduct mevcut mu
            $this->cartService->updateCartTotalByDestroyCartProduct($cartProduct); //Sipariş totalinden silinecek olan CartProduct totalini düşür.
            $this->remove($cartProduct); //CartProduct'dı sil
        });
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return CartProduct
     * @throws Exception
     */
    public function addCartProduct(Product $product, int $quantity): CartProduct
    {
        return $this->store([
            'cart' => $this->cartService->getDefaultCart(),
            'product' => $product,
            'quantity' => $quantity,
            'unitPrice' => $product->getPrice(),
            'total' => $this->productService->getTotalQuantityPriceByProduct($product, $quantity)
        ]);
    }
}