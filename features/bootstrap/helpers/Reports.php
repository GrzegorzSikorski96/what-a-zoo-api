<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\ReportCreator;
use App\Models\Report;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Reports
 * @package BehatTests\helpers
 */
trait Reports
{
    /**
     * @Given report with id :id reported by user with id :userId about review with id :reviewId exist
     * @param int $id
     * @param int $userId
     * @param int $reviewId
     * @throws BindingResolutionException
     */
    public function reportWithIdExist(int $id, int $userId, int $reviewId): void
    {
        /** @var ReportCreator $creator */
        $creator = app()->make(ReportCreator::class);
        $creator->createOrReplaceReport($id, $userId, $reviewId);
    }

    /**
     * @Given report with id :id not exist
     * @param $id
     */
    public function reportWithIdNotExist($id): void
    {
        if (Report::find($id)) {
            Report::find($id)->forceDelete();
        }
    }
}
