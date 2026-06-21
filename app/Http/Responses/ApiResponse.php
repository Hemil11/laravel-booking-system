<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * @param  array<string, array<int, string>>|null  $errors
     */
    public static function error(string $message, ?array $errors = null, int $status = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
