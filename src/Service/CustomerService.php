<?php

namespace App\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Exception;

class CustomerService extends BaseService
{
    /**
     * @param CustomerRepository $repository
     */
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return Customer|null
     * @throws Exception
     */
    public function getCustomer(array $criteria, array $orderBy = null, bool $notFoundException = true): ?Customer
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return Customer[]
     */
    public function getCustomerBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @return Customer
     * @throws Exception
     */
    public function getCustomerTest(): Customer
    {
        return $this->getCustomer(['id' => getCustomerId()]);
    }
}