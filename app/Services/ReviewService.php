<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Review;

/**
 * Class ReviewService
 * @package App\Services
 */
class ReviewService
{
    /**
     * @param array $data
     * @return Review
     */
    public function create(array $data): Review
    {
        $review = new Review($data);
        $review->save();

        return $review;
    }

    /**
     * @param array $data
     * @return Review
     */
    public function edit(array $data): Review
    {
        $review = Review::findOrFail($data['id']);
        $review->update($data);
        $review->save();

        return $review;
    }

    /**
     * @param int $id
     */
    public function remove(int $id): void
    {
        $review = Review::findOrFail($id);
        $review->delete();
    }
}
