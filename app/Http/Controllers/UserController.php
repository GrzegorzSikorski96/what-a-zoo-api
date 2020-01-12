<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param ApiResponse $apiResponse
     * @param UserService $userService
     */
    public function __construct(ApiResponse $apiResponse, UserService $userService)
    {
        parent::__construct($apiResponse);
        $this->userService = $userService;
    }

    /**
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        $users = $this->userService->users();

        return $this->apiResponse
            ->setData([
                'users' => $users,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function user(int $userId): JsonResponse
    {
        $user = $this->userService->user($userId);

        return $this->apiResponse
            ->setData([
                'user' => $user,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function visitedById(int $userId): JsonResponse
    {
        $visited = $this->userService->visited($userId);

        return $this->apiResponse
            ->setData([
                'visited' => $visited,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function loggedUserVisitedZoos(): JsonResponse
    {
        $visited = $this->userService->visited(auth()->id());

        return $this->apiResponse
            ->setData([
                'visited' => $visited,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function ban(int $userId): JsonResponse
    {
        $this->userService->ban($userId);

        return $this->apiResponse
            ->setMessage(__('messages.user.banned.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    public function unBan(int $userId): JsonResponse
    {
        $this->userService->unBan($userId);

        return $this->apiResponse
            ->setMessage(__('messages.user.unbanned.success'))
            ->setSuccessStatus()
            ->getResponse();
    }
}
