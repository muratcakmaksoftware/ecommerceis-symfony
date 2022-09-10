<?php

namespace App\Controller;

use App\Service\OrderProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * * @Route("/orders/order-product")
 */
class OrderProductController extends AbstractController
{
    /**
     * @var OrderProductService
     */
    private OrderProductService $orderProductService;

    /**
     * @param OrderProductService $orderProductService
     */
    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
    }
}
