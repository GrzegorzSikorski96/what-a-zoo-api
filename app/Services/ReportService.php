<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Report;
use App\Models\ReportActions;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class ReportService
 * @package App\Services
 */
class ReportService
{
    public function report(int $id): Report
    {
        return Report::findOrFail($id);
    }

    public function reports(): Collection
    {
        return Report::all();
    }

    /**
     * @param int $id
     * @return Report
     */
    public function create(int $id): Report
    {
        $review = Review::findOrFail($id);

        $report = new Report([
            'review_id' => $review->id,
            'reported_by' => auth()->id()
        ]);
        $report->save();

        return $report;
    }

    public function resolve(int $reportId, int $actionId)
    {
        $report = Report::findOrFail($reportId);
        ReportActions::findOrFail($actionId);

        $report->action_id = $actionId;
        $report->solved_at = Carbon::now();
        $report->save();

        switch ($actionId) {
            case ReportActions::REMOVE_REVIEW:
                $report->review->delete();
                break;
            case ReportActions::REMOVE_REVIEW_WITH_USER:
                $report->review->author()->withTrashed()->delete();
                $report->review->delete();
                break;
        }

        return $report;
    }
}
