<?php

namespace App\DataFixtures;

use App\Entity\Discount;
use App\Enum\DiscountStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $discount = new Discount();
        $discount->setType(1); //DiscountTypes
        $discount->setName('1000 TL üzeri 10% indirim');
        $discount->setStatus(DiscountStatus::ACTIVE);
        $discount->setDescription('Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.');
        $data = [
            'overPrice' => 1000,
            'percent' => 10
        ];
        $discount->setJsonData(json_encode($data));
        $manager->persist($discount);

        $discount = new Discount();
        $discount->setType(2);
        $discount->setName('2 Kategori ait 6 adet satın alımında ürün 1 tane ücretsiz');
        $discount->setStatus(DiscountStatus::ACTIVE);
        $discount->setDescription('2 ID\'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.');
        $data = [
            'categoryId' => 2,
            'buyPiece' => 6,
            'freePiece' => 1
        ];
        $discount->setJsonData(json_encode($data));
        $manager->persist($discount);

        $discount = new Discount();
        $discount->setType(3);
        $discount->setName('1 Kategori ait 2 veya daha fazla alımda en ucuza ürüne 20% indirim');
        $discount->setStatus(DiscountStatus::ACTIVE);
        $discount->setDescription('1 ID\'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.');
        $data = [
            'categoryId' => 1,
            'minBuyPiece' => 2,
            'percent' => 20
        ];
        $discount->setJsonData(json_encode($data));
        $manager->persist($discount);

        $manager->flush();
    }
}
