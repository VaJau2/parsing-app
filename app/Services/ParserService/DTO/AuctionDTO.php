<?php

namespace App\Services\ParserService\DTO;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\Organizer;

class AuctionDTO
{
    public function __construct(
        public readonly Auction $auction,
        public readonly Organizer $organizer,

        /** @var Lot[] $lots */
        public readonly array $lots,
    ) {}
}
