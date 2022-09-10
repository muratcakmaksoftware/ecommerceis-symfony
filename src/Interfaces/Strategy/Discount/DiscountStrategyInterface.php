<?php

namespace App\Interfaces\Strategy\Discount;

use App\Strategy\Discount\DiscountManagerStrategy;

interface DiscountStrategyInterface
{
    /**
     * @param DiscountManagerStrategy $discountManagerStrategy
     * @return mixed
     */
    public function runAlgorithm(DiscountManagerStrategy &$discountManagerStrategy);
}