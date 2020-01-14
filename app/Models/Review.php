<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Review
 * @package App\Models
 * @mixin Eloquent\
 * @property int $id
 * @property string $review
 * @property int $rating
 * @property int $zoo_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Review extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'reviews';

    /**
     * @var array
     */
    protected $fillable = [
        'review',
        'rating',
        'user_id',
        'zoo_id',
        'deleted_at'
    ];

    public function zoo(): BelongsTo
    {
        return $this->belongsTo(Zoo::class, 'zoo_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
