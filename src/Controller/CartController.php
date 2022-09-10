<?php

namespace App\Controller;

use App\Helper\ResponseHelper;
use App\Service\CartService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carts")
 */
class CartController extends AbstractController
{
    private CartService $cartService;

    /**
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Müşterinin siparişindeki tüm ürün bilgilerini döner.
     * @Route ("", name="carts", methods={"GET"})
     * @return JsonResponse
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        return ResponseHelper::success($this->cartService->index());
    }
}
