<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    protected function response(?array $data = [], ?string $message = '', $httpCode = 200): JsonResponse
    {
        return new JsonResponse(
            [
                'data' => $data,
                'message' => $message
            ],
            $httpCode
        );
    }
}
