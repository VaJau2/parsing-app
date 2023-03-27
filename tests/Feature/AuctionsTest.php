<?php

namespace Tests\Feature;

use App\Actions\ParseAuctionsAction;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\Organizer;
use App\Services\ParserService\Parsers\KartotekaParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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
                'status' => $auction->status,
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

    public function test_parsing_kartoteka()
    {
        Http::fake([
            'test.ru' => Http::response('<html lang="">
                <body>
                    <table class="data">
                        <tr>
                            <td> 4221 </td>
                            <td> Оранизатор </td>
                            <td>
                                <div> Должник </div>
                                <div> Лот, название <br> Лот, описание </div>
                            </td>
                            <td>статус</td>
                            <td>24.03.2023 11:00</td>
                        </tr>
                        <tr>Страница</tr>
                    </table>
                </body>
            </html>')
        ]);

        $action = new ParseAuctionsAction(new KartotekaParser('test.ru'));
        $action->execute(0);

        $auction = Auction::firstWhere('number', 4221);
        $this->assertNotEquals(null, $auction);
    }
}
