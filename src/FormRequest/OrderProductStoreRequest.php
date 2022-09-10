<?php

namespace App\FormRequest;

use App\Entity\Product;
use App\Validator as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;

class OrderProductStoreRequest extends BaseRequest
{
    public function getRules(): Assert\Collection
    {
        return new Assert\Collection([
            'product_id' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new AcmeAssert\TableRecordExists(Product::class)
            ],
            'quantity' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
            ]
        ]);
    }
}