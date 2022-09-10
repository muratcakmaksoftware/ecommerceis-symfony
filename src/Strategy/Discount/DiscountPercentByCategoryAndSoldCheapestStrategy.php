<?php

namespace App\Strategy\Discount;

use App\Enum\DiscountStatus;
use App\Enum\DiscountType;
use App\Helper\CalculationHelper;
use App\Interfaces\Strategy\Discount\DiscountStrategyInterface;

class DiscountPercentByCategoryAndSoldCheapestStrategy implements DiscountStrategyInterface
{
    /**
     * Belirli kategori ve satış adetine göre en ucuz üründen belirlenen yüzde kadar indirim yapılır.
     * @param DiscountManagerStrategy $dms
     * @return void
     */
    public function runAlgorithm(DiscountManagerStrategy &$dms): void
    {
        $discountDetails = $dms->getDiscountService()->getDiscountBy([
            'type' => DiscountType::PERCENT_CATEGORY_SOLD_CHEAPEST,
            'status' => DiscountStatus::ACTIVE
        ]);

        foreach ($discountDetails as $discountDetail) {
            $jsonData = $discountDetail->getJsonData();

            $minBuyPrice = 0;
            foreach ($dms->getCartProducts() as $cartProduct) {
                if ($cartProduct->getProduct()->getCategory()->getId() == $jsonData['categoryId'] &&
                    $cartProduct->getQuantity() >= $jsonData['minBuyPiece']) {

                    if ($minBuyPrice == 0) { //Default en dusuk fiyatin belirlenmesi
                        $minBuyPrice = $cartProduct->getUnitPrice();
                    } else if ($minBuyPrice > $cartProduct->getUnitPrice()) { //En dusuk fiyatin bulunmasi
                        $minBuyPrice = $cartProduct->getUnitPrice();
                    }
                }
            }

            if ($minBuyPrice != 0) {
                $discountAmount = round(CalculationHelper::calculatePercent($minBuyPrice, $jsonData['percent']), 2);
                $dms->addDiscountMessage($discountDetail->getId(), $dms->getDiscountTypes()[DiscountType::PERCENT_CATEGORY_SOLD_CHEAPEST], $discountAmount);
            }
        }
    }
}