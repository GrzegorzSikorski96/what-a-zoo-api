<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @mixin Eloquent\
 * @property int $id
 * @property string $action
 */
class FeedAction extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var integer
     */
    const VISIT = 1;
    /**
     * @var integer
     */
    const ADD_REVIEW = 2;

    /**
     * @var string
     */
    protected $table = 'feed_actions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
    ];
}
