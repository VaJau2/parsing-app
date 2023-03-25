<?php

namespace App\Actions;

use App\Models\Auction;

class GetAuctionAction
{
    public function execute(string $number): Auction
    {
        return Auction::where('number', $number)->firstOrFail();
    }
}
