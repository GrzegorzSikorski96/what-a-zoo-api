<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Models\Review;

/**
 * Trait Reviews
 * @package BehatTests\helpers
 */
trait Reviews
{
    /**
     * @Given Logged user never add review to zoo with id :id
     * @param int $id
     */
    public function loggedUserNeverAddReviewToZooWithId(int $id): void
    {
        $review = Review::where('zoo_id', $id)->where('user_id', auth()->id())->first();

        if ($review) {
            $review->forceDelete();
        }
    }
}
