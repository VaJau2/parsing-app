<?php

namespace App\Services\ParserService;

use App\Services\ParserService\DTO\AuctionDTO;

interface ParserInterface
{
    public function initUrl(string $url): self;

    /**
     * @param int $page
     * @return AuctionDTO[]
     */
    public function parse(int $page): array;
}
