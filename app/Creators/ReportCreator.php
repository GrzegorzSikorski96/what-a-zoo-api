<?php

declare(strict_types=1);

namespace App\Creators;

use App\Models\Report;

/**
 * Class ReportCreator
 * @package Sms\Creators
 */
class ReportCreator
{
    /**
     * @param int $id
     * @param int $userId
     * @param int $reviewId
     * @return void
     */
    public function createOrReplaceReport(int $id, int $userId, int $reviewId): void
    {
        $report = Report::updateOrCreate(
            ['id' => $id],
            [
                'review_id' => $reviewId,
                'reported_by' => $userId,
                'solved_at' => null,
                'action_id' => null,
            ]
        );

        $report->save();

        $author = $report->review->author()->withTrashed()->firstOrFail();
        $author->deleted_at = null;
        $author->save();
    }
}
