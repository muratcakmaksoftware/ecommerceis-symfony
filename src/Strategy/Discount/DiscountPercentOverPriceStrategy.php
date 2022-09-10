<?php

namespace App\Strategy\Discount;

use App\Enum\DiscountStatus;
use App\Enum\DiscountType;
use App\Helper\CalculationHelper;
use App\Interfaces\Strategy\Discount\DiscountStrategyInterface;

class DiscountPercentOverPriceStrategy implements DiscountStrategyInterface
{
    /**
     * Belirlenen sipariş toplam tutar sayısına göre X% indirim eklenmesi.
     * @param DiscountManagerStrategy $dms
     * @return void
     */
    public function runAlgorithm(DiscountManagerStrategy &$dms): void
    {
        $discountDetails = $dms->getDiscountService()->getDiscountBy([
            'type' => DiscountType::PERCENT_OVER_PRICE,
            'status' => DiscountStatus::ACTIVE
        ]);

        foreach ($discountDetails as $discountDetail) {
            $jsonData = $discountDetail->getJsonData();
            if ($dms->getCartTotal() >= $jsonData['overPrice']) {
                $discountAmount = CalculationHelper::calculatePercent($dms->getCartTotal(), $jsonData['percent']); //Totalden yüzde alımı
                $dms->addDiscountMessage($discountDetail->getId(), $dms->getDiscountTypes()[DiscountType::PERCENT_OVER_PRICE], $discountAmount);
            }
        }
    }
}