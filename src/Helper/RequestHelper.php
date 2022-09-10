<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestHelper
{
    /**
     * @param Request $request
     * @return array
     */
    public static function getJson(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException(400, 'Invalid json');
        }

        return $data;
    }

    /**
     * @param RequestStack $request
     * @return array
     */
    public static function getStackJson(RequestStack $request): array
    {
        $data = json_decode($request->getCurrentRequest()->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException(400, 'Invalid json');
        }

        return $data;
    }
}