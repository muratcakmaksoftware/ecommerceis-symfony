<?php

namespace App\Enum;

abstract class DiscountType
{
    const PERCENT_OVER_PRICE = 1;
    const FREE_PIECE_BY_CATEGORY_AND_SOLD_PIECE = 2;
    const PERCENT_CATEGORY_SOLD_CHEAPEST = 3;
}