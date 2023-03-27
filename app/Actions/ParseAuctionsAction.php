<?php

namespace App\Actions;

use App\Models\Auction;
use App\Services\ParserService\ParserInterface;

class ParseAuctionsAction
{
    public function __construct(
        private readonly ParserInterface $parser,
    ) {}

    public function execute(int $page): void
    {
        $parseResult = $this->parser->parse($page);

        foreach ($parseResult as $auctionDTO)
        {
            $existingAuction = Auction::firstWhere('number', $auctionDTO->auction->number);

            if (!empty($existingAuction))
            {
                UpdateAuctionStatusAction::for($existingAuction)->execute($auctionDTO->auction->status);
            }
            else
            {
                CreateAuctionFromDtoAction::from($auctionDTO)->execute();
            }
        }

    }
}
