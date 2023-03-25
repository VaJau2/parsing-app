<?php

namespace App\Http\Resources;

use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Lot
 */
class LotResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'description' => $this->description,
        ];
    }
}
