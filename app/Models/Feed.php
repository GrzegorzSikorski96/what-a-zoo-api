<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class User
 * @package App\Models
 * @mixin Eloquent\
 * @property int $id
 * @property int $zoo_id
 * @property int $action_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Feed extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_feeds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'zoo_id', 'action_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function zoo(): BelongsTo
    {
        return $this->belongsTo(Zoo::class, 'zoo_id');
    }

    /**
     * @return BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(FeedAction::class, 'action_id');
    }
}
