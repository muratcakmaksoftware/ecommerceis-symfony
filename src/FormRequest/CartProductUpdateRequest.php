<?php

namespace App\FormRequest;

use App\Entity\CartProduct;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;

class CartProductUpdateRequest extends BaseRequest
{
    public function getRules(): Assert\Collection
    {
        new AcmeAssert\TableRecordExists(CartProduct::class, [
            'id' => $this->getRouteParam('cartProductId')
        ]);

        return new Assert\Collection([
            'quantity' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
            ]
        ]);
    }
}