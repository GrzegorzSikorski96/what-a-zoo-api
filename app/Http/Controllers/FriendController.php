<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\FriendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class FriendController
 * @package App\Http\Controllers
 */
class FriendController extends Controller
{
    /**
     * @var FriendService
     */
    protected $friendService;

    /**
     * FriendController constructor.
     * @param ApiResponse $apiResponse
     * @param FriendService $friendService
     */
    public function __construct(ApiResponse $apiResponse, FriendService $friendService)
    {
        parent::__construct($apiResponse);
        $this->friendService = $friendService;
    }

    /**
     * @return JsonResponse
     */
    public function friends(): JsonResponse
    {
        $friends = $this->friendService->friends();

        return $this->apiResponse
            ->setData([
                'friends' => $friends,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->sendFriendRequest($request->all()['friend_id']);

        return $this->apiResponse
            ->setMessage(__('messages.friends.request.send'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->acceptFriendRequest($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('zaakceptowano zaproszenie do znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->rejectFriendRequest($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('odrzucono zaproszenie do znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeFriend(Request $request): JsonResponse
    {
        $this->friendService->removeFriend($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('usunięto ze znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }
}
