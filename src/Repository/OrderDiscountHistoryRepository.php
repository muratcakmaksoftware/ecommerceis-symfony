<?php

namespace App\Repository;

use App\Entity\OrderDiscountHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderDiscountHistory>
 *
 * @method OrderDiscountHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDiscountHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDiscountHistory[]    findAll()
 * @method OrderDiscountHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDiscountHistoryRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDiscountHistory::class);
    }
}
