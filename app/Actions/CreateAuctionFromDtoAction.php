<?php

namespace App\Actions;

use App\Models\Organizer;
use App\Services\ParserService\DTO\AuctionDTO;

class CreateAuctionFromDtoAction
{
    public function __construct(
        private readonly AuctionDTO $auctionDTO
    ){}

    public static function from(AuctionDTO $auctionDTO): self
    {
        return new self($auctionDTO);
    }

    public function execute(): void
    {
        $organizer = Organizer::firstWhere('name', $this->auctionDTO->organizer->name);
        if (empty($organizer))
        {
            $organizer = $this->auctionDTO->organizer;
            $organizer->save();
        }

        $auction = $this->auctionDTO->auction;
        $auction->organizer()->associate($organizer);
        $auction->save();

        $lots = $this->auctionDTO->lots;
        foreach ($lots as $lot)
        {
            $lot->auction()->associate($auction);
            $lot->save();
        }
    }
}
