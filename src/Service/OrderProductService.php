<?php

namespace App\Service;

use App\Entity\CartProduct;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderProductRepository;
use Exception;

class OrderProductService extends BaseService
{
    /**
     * @throws Exception
     */
    public function __construct(OrderProductRepository $repository)
    {
        $this->repository = $repository;
        $this->em = $this->repository->getEntityManager();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return OrderProduct|null
     * @throws Exception
     */
    public function getOrderProduct(array $criteria, array $orderBy = null, bool $notFoundException = true): ?OrderProduct
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return OrderProduct[]
     */
    public function getOrderProductBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Cart bilgilerini Order Product ekler
     * @param Order $order
     * @param CartProduct $cartProduct
     * @return void
     */
    public function addCartProductToOrderProduct(Order $order, CartProduct $cartProduct)
    {
        $this->store([
            'order' => $order,
            'product' => $cartProduct->getProduct(),
            'quantity' => $cartProduct->getQuantity(),
            'unitPrice' => $cartProduct->getUnitPrice(),
            'total' => $cartProduct->getTotal()
        ]);
    }
}