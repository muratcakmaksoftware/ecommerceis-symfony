<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Exception;

class ProductService extends BaseService
{
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param bool $notFoundException
     * @return Product|null
     * @throws Exception
     */
    public function getProduct(array $criteria, array $orderBy = null, bool $notFoundException = true): ?Product
    {
        return $this->findOneBy($criteria, $orderBy, $notFoundException);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return Product[]
     */
    public function getProductBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return void
     * @throws Exception
     */
    public function checkStockQuantityByProduct(Product $product, int $quantity)
    {
        if ($quantity > $product->getStock()) {
            throw new Exception('products.stock');
        }
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return float|int
     */
    public function getTotalQuantityPriceByProduct(Product $product, int $quantity)
    {
        return $product->getPrice() * $quantity;
    }
}