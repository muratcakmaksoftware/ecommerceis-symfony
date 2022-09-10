<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;

class CalculationHelper
{
    /**
     * @param $val
     * @param $percent
     * @return float
     */
    public static function calculatePercent($val, $percent): float
    {
        return round((($val / 100) * $percent),2);
    }
}