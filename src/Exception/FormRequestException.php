<?php

namespace App\Exception;

use App\Helper\GeneralHelper;
use App\Helper\ValidationHelper;
use Exception;
use Throwable;

class FormRequestException extends Exception
{
    private $errors;

    public function __construct($errors, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Form Request Error", $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return ValidationHelper::getErrorMessages($this->errors);
    }

}