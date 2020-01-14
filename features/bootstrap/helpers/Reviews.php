<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\ReviewCreator;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;

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

    /**
     * @Given review with id :id exist
     * @param int $id
     * @throws BindingResolutionException
     */
    public function reviewWithIdExist(int $id): void
    {
        /** @var ReviewCreator $creator */
        $creator = app()->make(ReviewCreator::class);
        $creator->createOrReplaceReviewWithId($id);
    }

    /**
     * @Given review with id :id author is logged user
     * @param int $id
     */
    public function reviewAuthorIsLoggedUser(int $id): void
    {
        $review = Review::withTrashed()->findOrFail($id);
        $review->user_id = auth()->id();
        $review->save();
    }

    /**
     * @Given review with id :id author is not logged user
     * @param int $id
     */
    public function reviewAuthorIsNotLoggedUser(int $id): void
    {
        $review = Review::withTrashed()->findOrFail($id);
        $user = User::where('id', '!=', auth()->id())->inRandomOrder()->first();

        if ($review->zoo->reviews()->where('user_id', $user->id)->exists()) {
            $user->reviews()->where('zoo_id', $review->zoo->id)->forceDelete();
        }

        $review->user_id = $user->id;
        $review->save();
    }
}
