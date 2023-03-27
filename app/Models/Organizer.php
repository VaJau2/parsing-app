<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\OrganizerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Модель организатора
 *
 * @property int $id
 * @property string $name
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 *
 * @property Collection|Auction[] $auctions
 */
class Organizer extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public static function newFactory(): OrganizerFactory
    {
        return OrganizerFactory::new();
    }
}
