<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\FeedService;
use Illuminate\Http\JsonResponse;

/**
 * Class FeedController
 * @package App\Http\Controllers
 */
class FeedController extends Controller
{
    /**
     * @var FeedService
     */
    protected $feedService;

    /**
     * FeedController constructor.
     * @param ApiResponse $apiResponse
     * @param FeedService $feedService
     */
    public function __construct(ApiResponse $apiResponse, FeedService $feedService)
    {
        parent::__construct($apiResponse);
        $this->feedService = $feedService;
    }

    /**
     * @return JsonResponse
     */
    public function loggedUserFeed(): JsonResponse
    {
        $feed = $this->feedService->loggedUserFeed();

        return $this->apiResponse
            ->setData([
                'news' => $feed,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function userFeed(int $id): JsonResponse
    {
        $feed = $this->feedService->userFeed($id);

        return $this->apiResponse
            ->setData([
                'news' => $feed,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }
}
