<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function success($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_OK, $attributes, $message ?? "Successfully Done");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function store($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_OK, $attributes, $message ?? "Successfully Saved");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function update($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_OK, $attributes, $message ?? "Successfully Updated");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function destroy($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_OK, $attributes, $message ?? "Successfully Deleted");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function restore($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_OK, $attributes, $message ?? "Successfully Restored");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function badRequest($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_BAD_REQUEST, $attributes, $message ?? "Bad Request");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function unAuthorized($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_UNAUTHORIZED, $attributes, $message ?? "Unauthorized");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function notFound($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_NOT_FOUND, $attributes, $message ?? "Not Found");
    }

    /**
     * @param $attributes
     * @param string|null $message
     * @return JsonResponse
     */
    public static function internalServerError($attributes = null, string $message = null): JsonResponse
    {
        return self::response(Response::HTTP_INTERNAL_SERVER_ERROR, $attributes, $message ?? "Internal Server Error");
    }

    /**
     * @param int $statusCode
     * @param $attributes
     * @param string $message
     * @return JsonResponse
     */
    public static function response(int $statusCode, $attributes, string $message): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'data' => $attributes
        ], $statusCode);
    }

}