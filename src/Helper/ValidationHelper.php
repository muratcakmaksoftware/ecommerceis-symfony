<?php

namespace App\Helper;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationHelper
{
    /**
     * @param ConstraintViolationList $errors
     * @return array
     */
    public static function getErrorMessages(ConstraintViolationList $errors): array
    {
        $messages = [];
        foreach ($errors as $error){
            $messages[$error->getPropertyPath()][] = $error->getMessage();
        }
        return $messages;
    }
}