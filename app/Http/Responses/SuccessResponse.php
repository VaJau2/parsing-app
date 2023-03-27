<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class SuccessResponse implements Responsable
{
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
        ]);
    }
}
