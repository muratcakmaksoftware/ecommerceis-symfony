<?php

namespace App\Strategy\Discount;

use App\Enum\DiscountStatus;
use App\Enum\DiscountType;
use App\Interfaces\Strategy\Discount\DiscountStrategyInterface;

class DiscountFreePieceByCategoryAndSoldPieceStrategy implements DiscountStrategyInterface
{
    /**
     * Belirlenen kategori bilgisine ve satın aldığı adete göre düşülecek olan adet fiyat bilgisini indirime ekler.
     * @param DiscountManagerStrategy $dms
     * @return void
     */
    public function runAlgorithm(DiscountManagerStrategy &$dms): void
    {
        $discountDetails = $dms->getDiscountService()->getDiscountBy([
            'type' => DiscountType::FREE_PIECE_BY_CATEGORY_AND_SOLD_PIECE,
            'status' => DiscountStatus::ACTIVE
        ]);

        foreach ($discountDetails as $discountDetail) {
            $jsonData = $discountDetail->getJsonData();

            foreach ($dms->getCartProducts() as $cartProduct) {
                if ($cartProduct->getProduct()->getCategory()->getId() == $jsonData['categoryId']
                    && $cartProduct->getQuantity() == $jsonData['buyPiece']) {

                    $discountAmount = round($cartProduct->getUnitPrice() * $jsonData['freePiece'], 2);
                    $dms->addDiscountMessage($discountDetail->getId(), $dms->getDiscountTypes()[DiscountType::FREE_PIECE_BY_CATEGORY_AND_SOLD_PIECE], $discountAmount);
                    break;
                }
            }
        }
    }
}