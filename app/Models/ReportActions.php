<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ReportActions
 * @package App\Models
 */
class ReportActions extends Model
{
    /**
     * @var string
     */
    protected $table = 'report_actions';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var integer
     */
    const RESTORE_REVIEW = 1;
    /**
     * @var integer
     */
    const REMOVE_REVIEW = 2;
    /**
     * @var integer
     */
    const REMOVE_REVIEW_WITH_USER = 3;

    /**
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'action_id');
    }
}
