<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponse
{
    protected function response(
        ?array $data = [],
        ?string $message = '',
        $httpCode = 200
    ): JsonResponse {
        return new JsonResponse(
            ['data' => $data, 'message' => $message],
            $httpCode
        );
    }

    protected function resourceResponse(
        JsonResource $resource,
        ?string $message = '',
        $httpCode = 200
    ): JsonResponse {
        return $resource
            ->additional(['message' => $message])
            ->response()
            ->setStatusCode($httpCode);
    }
}
