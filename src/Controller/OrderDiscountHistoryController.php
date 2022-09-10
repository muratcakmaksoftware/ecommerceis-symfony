<?php

namespace App\Controller;

use App\Service\OrderDiscountHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * * @Route("/order-discount-history")
 */
class OrderDiscountHistoryController extends AbstractController
{
    /**
     * @var OrderDiscountHistoryService
     */
    private OrderDiscountHistoryService $orderDiscountHistoryService;

    /**
     * @param OrderDiscountHistoryService $orderDiscountHistoryService
     */
    public function __construct(OrderDiscountHistoryService $orderDiscountHistoryService)
    {
        $this->orderDiscountHistoryService = $orderDiscountHistoryService;
    }
}
