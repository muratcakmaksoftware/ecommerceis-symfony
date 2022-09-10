<?php

namespace App\Helper;

use ReflectionClass;
use ReflectionException;

class ArrayHelper
{
    /**
     * @param $class
     * @return array
     * @throws ReflectionException
     */
    public static function getReflactionClassWithFlip($class): array
    {
        return array_flip((new ReflectionClass($class))->getConstants());
    }
}