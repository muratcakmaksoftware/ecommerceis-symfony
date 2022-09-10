<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
    }

    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
            CategoryFixtures::class,
            ProductFixtures::class,
            CartFixtures::class,
            DiscountFixtures::class
        ];
    }
}
