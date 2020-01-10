<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Report
 * @package App\Models
 * @package App\Models
 * @mixin Eloquent\
 * @property int $id
 * @property int $review_id
 * @property int $reported_by
 * @property Carbon $solved_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Report extends Model
{
    /**
     * @var string
     */
    protected $table = 'reports';

    /**
     * @var array
     */
    protected $fillable = [
        'solved_at',
        'review_id',
        'reported_by',
    ];

    /**
     * @return BelongsTo
     */
    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * @return BelongsTo
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
