<?php

namespace App\Http\Resources;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс торга вместе с организатором и всеми лотами
 *
 * @mixin Auction
 */
class AuctionWithDataResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'state' => $this->state,
            'organizer' => new OrganizerResource($this->organizer),
            'lots' => LotResource::collection($this->lots),
        ];
    }
}
