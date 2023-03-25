<?php

namespace Tests\Feature;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\Organizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuctionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_auction()
    {
        /** @var Organizer $organizer */
        $organizer = Organizer::factory()->create();

        /** @var Auction $auction */
        $auction = Auction::factory()->for($organizer)->create();

        /** @var Lot $lot */
        $lot = Lot::factory()->for($auction)->create();

        $this->get("/api/auctions/?number={$auction->number}")
            ->assertStatus(200)
            ->assertJson([
                'number' => $auction->number,
                'state' => $auction->state,
                'organizer' => [
                    'name' => $organizer->name,
                ],
                'lots' => [
                    [
                        'description' => $lot->description,
                    ]
                ]
            ]);
    }
}
