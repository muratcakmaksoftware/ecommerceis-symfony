<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CartFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'quantity' => 10,
            ],
            [
                'quantity' => 2,
            ],
            [
                'quantity' => 1,
            ],
            [
                'quantity' => 6,
            ],
            [
                'quantity' => 10,
            ]
        ];
        $dataCount = count($data) - 1;

        $products = $manager->getRepository(Product::class)->findAll();
        $customers = $manager->getRepository(Customer::class)->findAll();

        foreach ($customers as $customer) {
            $cartTotal = 0;
            $cart = new Cart(); //siparis
            $cart->setCustomer($customer);
            $cart->setTotal($cartTotal);
            $manager->persist($cart);

            foreach ($products as $product) {
                $randomData = $data[rand(0, $dataCount)];
                $total = $product->getPrice() * $randomData['quantity'];
                $cartTotal += $total;

                $cartProduct = new CartProduct();
                $cartProduct->setCart($cart);
                $cartProduct->setProduct($product);
                $cartProduct->setQuantity($randomData['quantity']);
                $cartProduct->setUnitPrice($product->getPrice());
                $cartProduct->setTotal($total);
                $manager->persist($cartProduct);
            }

            $cart->setTotal($cartTotal); //Urun totalinin siparise yansitilmasi
            $manager->persist($cart);
        }

        $manager->flush();
    }
}
