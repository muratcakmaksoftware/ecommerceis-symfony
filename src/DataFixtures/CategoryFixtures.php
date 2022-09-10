<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'name' => 'Giyim'
            ],
            [
                'name' => 'Teknoloji'
            ],
            [
                'name' => 'Araç'
            ],
        ];

        foreach ($data as $item){
            $category = new Category();
            $category->setName($item['name']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
