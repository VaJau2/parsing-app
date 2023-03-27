<?php

namespace App\Actions;

use App\Models\Auction;

class UpdateAuctionStatusAction
{
    public function __construct(
        private readonly Auction $auction,
    ){}

    public static function for(Auction $auction): self
    {
        return new self($auction);
    }

    public function execute(string $newStatus): void
    {
        if ($this->auction->status == $newStatus)
        {
            return;
        }

        $this->auction->status = $newStatus;
        $this->auction->save();
    }
}
