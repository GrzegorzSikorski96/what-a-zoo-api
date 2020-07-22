<?php

declare(strict_types=1);

namespace App\Creators;

use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Exception;

/**
 * Class ReviewCreator
 * @package Sms\Creators
 */
class ReviewCreator
{
    /**
     * @param int $reviewId
     * @return void
     * @throws Exception
     */
    public function createOrReplaceReviewWithId(int $reviewId): void
    {
        if (Review::withTrashed()->find($reviewId)) {
            Review::withTrashed()->find($reviewId)->update([
                'review' => 'testReview',
                'rating' => random_int(1, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ]);
        } else {
            $user = User::all()->random()->first();
            $zoo = $user->visitedZoos->random();

            if (!$zoo->reviews()->where('user_id', $user->id)->exists()) {
                Review::create(
                    [
                        'review' => 'testReview',
                        'rating' => random_int(1, 5),
                        'user_id' => $user->id,
                        'zoo_id' => $zoo->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null,
                    ]
                );
            }
        }
    }

    /**
     * @param int $reviewid
     * @return void
     */
    public function removeReviewIfExists(int $reviewid): void
    {
        Review::findOrFail($reviewid)->delete();
    }
}
