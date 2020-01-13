<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;

/**
 * Class ReviewController
 * @package App\Http\Controllers
 */
class ReviewController extends Controller
{
    /**
     * @var ReviewService
     */
    protected $reviewService;

    /**
     * ReviewController constructor.
     * @param ApiResponse $apiResponse
     * @param ReviewService $reviewService
     */
    public function __construct(ApiResponse $apiResponse, ReviewService $reviewService)
    {
        parent::__construct($apiResponse);
        $this->reviewService = $reviewService;
    }

    /**
     * @param Review $request
     * @return JsonResponse
     */
    public function create(Review $request): JsonResponse
    {
        $review = $this->reviewService->create($request->all());

        return $this->apiResponse
            ->setData([
                'review' => $review,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Review $review
     * @return JsonResponse
     */
    public function edit(Review $review): JsonResponse
    {
        $edited = $this->reviewService->edit($review->all());

        return $this->apiResponse
            ->setData([
                'edited' => $edited,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }
}
