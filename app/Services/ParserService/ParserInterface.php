<?php

namespace App\Services\ParserService;

use App\Services\ParserService\DTO\AuctionDTO;

interface ParserInterface
{
    public function __construct(string $url);

    /**
     * @param int $page
     * @return AuctionDTO[]
     */
    public function parse(int $page): array;
}
