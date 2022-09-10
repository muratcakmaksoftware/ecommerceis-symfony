<?php

namespace App\Controller;

use App\Helper\ResponseHelper;
use App\Service\DiscountService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discounts")
 */
class DiscountController extends AbstractController
{
    /**
     * @var DiscountService
     */
    private DiscountService $discountService;

    /**
     * @param DiscountService $discountService
     */
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Sepetdeki ürünlere göre indirimleri hesaplar
     * @Route ("/cart", name="discount_cart", methods={"GET"})
     * @return JsonResponse
     * @throws Exception
     */
    public function cartDiscount(): JsonResponse
    {
        return ResponseHelper::success($this->discountService->cartDiscountAnalysis());
    }
}
