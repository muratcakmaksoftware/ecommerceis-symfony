<?php

namespace App\EventListener;

use App\Entity\OrderProduct;
use App\Service\ProductService;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrderProductListener
{
    protected EntityManager $entityManager;
    protected ProductService $productService;

    public function __construct(EntityManager $entityManager, ProductService $productService)
    {
        $this->entityManager = $entityManager;
        $this->productService = $productService;
    }

    public function postPersist(OrderProduct $orderProduct, LifecycleEventArgs $event): void
    {
        $product = $orderProduct->getProduct();
        $this->productService->update($product, [
                'stock' => ($product->getStock() - $orderProduct->getQuantity())
            ]
        );
    }
}