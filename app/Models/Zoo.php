<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Zoo
 * @package App\Models
 * @mixin Eloquent\
 * @property int $id
 * @property string $name
 * @property double $latitude
 * @property double $longitude
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Zoo extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'zoos';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return BelongsToMany
     */
    public function visitedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'visited_zoos', 'zoo_id');
    }
}