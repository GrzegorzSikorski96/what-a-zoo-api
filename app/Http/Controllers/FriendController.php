<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\FriendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    protected $friendService;

    public function __construct(ApiResponse $apiResponse, FriendService $friendService)
    {
        parent::__construct($apiResponse);
        $this->friendService = $friendService;
    }

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

    public function sendFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->sendFriendRequest($request->all()['friend_id']);

        return $this->apiResponse
            ->setMessage(__('messages.friends.request.send'))
            ->setSuccessStatus()
            ->getResponse();
    }

    public function acceptFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->acceptFriendRequest($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('zaakceptowano zaproszenie do znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }

    public function rejectFriendRequest(Request $request): JsonResponse
    {
        $this->friendService->rejectFriendRequest($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('odrzucono zaproszenie do znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }

    public function removeFriend(Request $request): JsonResponse
    {
        $this->friendService->removeFriend($request->all()['user_id']);

        return $this->apiResponse
            ->setMessage('usunięto ze znajomych')
            ->setSuccessStatus()
            ->getResponse();
    }
}
