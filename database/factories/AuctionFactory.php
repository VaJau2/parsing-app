<?php

namespace Database\Factories;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * @extends Factory<Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => Str::random(6),
            'status' => fake()->text(),
            'date_start' => Date::now(),
            'debtor_name' => fake()->name(),
        ];
    }
}
