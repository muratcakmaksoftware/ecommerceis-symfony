<?php

namespace App\EventListener;

use App\Entity\CartProduct;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class CartProductListener
{
    protected EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function preRemove(CartProduct $cartProduct, LifecycleEventArgs $event): void
    {
        //
    }

    public function postRemove(CartProduct $cartProduct, LifecycleEventArgs $event): void
    {
        //
    }

    public function prePersist(CartProduct $cartProduct, LifecycleEventArgs $event): void
    {
        //
    }

    public function postPersist(CartProduct $cartProduct, LifecycleEventArgs $event): void
    {
        //
    }

    public function preUpdate(CartProduct $cartProduct, PreUpdateEventArgs $event): void
    {
        //
    }

    public function postUpdate(CartProduct $cartProduct, LifecycleEventArgs $event): void
    {
        //
    }
}