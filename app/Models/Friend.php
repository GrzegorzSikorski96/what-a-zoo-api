<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Friend
 * @package App\Models
 * @mixin Eloquent\
 * @property int $user_id
 * @property int $friend_id
 * @property Carbon $accepted_at
 */
class Friend extends Model
{
    /**
     * @var string
     */
    protected $table = 'friends';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'friend_id',
        'accepted_at',
    ];
}
