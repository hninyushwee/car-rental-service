<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Success Response Format
     */
    public function successResponse($data = null, string $message = 'success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
            'errors'    => null
        ], $statusCode);
    }

    /**
     * Error Response Format
     */
    public function errorResponse(string $message = 'An error occurred', int $statusCode = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => null,
            'errors'    => $errors
        ], $statusCode);
    }
}