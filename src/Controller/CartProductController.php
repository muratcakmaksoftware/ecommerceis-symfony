<?php

namespace App\Controller;

use App\FormRequest\CartProductStoreRequest;
use App\FormRequest\CartProductUpdateRequest;
use App\Helper\ResponseHelper;
use App\Service\CartProductService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * * @Route("/carts/cart-product")
 */
class CartProductController extends AbstractController
{
    /**
     * @var CartProductService
     */
    private CartProductService $cartProductService;

    /**
     * @param CartProductService $cartProductService
     */
    public function __construct(CartProductService $cartProductService)
    {
        $this->cartProductService = $cartProductService;
    }

    /**
     * Sepete ürünü ekler
     * @Route ("", name="store_cart_product", methods={"POST"})
     * @param CartProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(CartProductStoreRequest $request): JsonResponse
    {
        $this->cartProductService->storeCartProduct($request->all());
        return ResponseHelper::store();
    }

    /**
     * Sepetdeki ürünü günceller
     * @Route ("/{cartProductId}", name="update_cart_product", methods={"PUT"}, requirements={"cartProductId"="\d+"})
     * @param int $cartProductId
     * @param CartProductUpdateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(CartProductUpdateRequest $request, int $cartProductId): JsonResponse
    {
        $this->cartProductService->updateCartProduct($request->all(), $cartProductId);
        return ResponseHelper::update();
    }

    /**
     * Sepetden ürünü kaldırır.
     * @Route ("/{cartProductId}", name="destroy_cart_product", methods={"DELETE"}, requirements={"cartProductId"="\d+"})
     * @param $cartProductId
     * @return JsonResponse
     */
    public function destroy($cartProductId): JsonResponse
    {
        $this->cartProductService->destroyCartProduct($cartProductId);
        return ResponseHelper::destroy();
    }
}
