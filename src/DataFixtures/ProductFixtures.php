<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                "name" => "Black&Decker A7062 40 Parça Cırcırlı Tornavida Seti",
                "price" => 120.75,
                "stock" => 10
            ],
            [
                'name' => 'Reko Mini Tamir Hassas Tornavida Seti 32\'li',
                'price' => 49.50,
                'stock' => 10,
            ],
            [
                'name' => 'Viko Karre Anahtar - Beyaz',
                'price' => 11.28,
                'stock' => 10,
            ],
            [
                'name' => 'Legrand Salbei Anahtar, Alüminyum',
                'price' => 22.80,
                'stock' => 10,
            ],
            [
                'name' => 'Schneider Asfora Beyaz Komütatör',
                'price' => 12.95,
                'stock' => 10,
            ]
        ];

        $categories = $manager->getRepository(Category::class)->findAll();
        $categoryCount = count($categories) - 1;
        $categoryIndex = 0;

        foreach ($data as $item) {
            $product = new Product();
            $product->setName($item['name']);
            $product->setCategory($categories[$categoryIndex]);
            $categoryIndex >= $categoryCount ? $categoryIndex = 0 : $categoryIndex++;
            $product->setPrice($item['price']);
            $product->setStock($item['stock']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
