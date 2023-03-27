<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\AuctionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Модель торга
 *
 * @property int $id
 * @property string $number
 * @property string $status
 * @property string $debtor_name
 * @property CarbonInterface|null $date_start
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 *
 * @property Collection|Lot[] $lots
 * @property Organizer $organizer
 */
class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'status', 'debtor_name',
        'date_start', 'organizer_id',
    ];

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public static function newFactory(): AuctionFactory
    {
        return AuctionFactory::new();
    }
}
