<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\LotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель лота
 *
 * @property int $id
 * @property string $description
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 *
 * @property Auction $auction
 */
class Lot extends Model
{
    use HasFactory;

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public static function newFactory(): LotFactory
    {
        return LotFactory::new();
    }
}
