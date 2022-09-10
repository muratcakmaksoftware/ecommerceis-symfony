<?php

namespace App\Service;

use App\Repository\OrderDiscountHistoryRepository;

class OrderDiscountHistoryService extends BaseService
{
    public function __construct(OrderDiscountHistoryRepository $repository)
    {
        $this->repository = $repository;
    }
}