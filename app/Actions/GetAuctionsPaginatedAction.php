<?php

namespace App\Actions;

use App\Models\Auction;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAuctionsPaginatedAction
{
    private const PAGE_COUNT = 15;

    public function execute(int $pageCount = 0): LengthAwarePaginator
    {
        $pageCount = ($pageCount > 0)
            ? $pageCount
            : self::PAGE_COUNT;

        return Auction::paginate($pageCount);
    }
}
