<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Login;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * Create a new AuthController instance.
     *
     * @param ApiResponse $apiResponse
     * @param TokenService $tokenService
     */
    public function __construct(ApiResponse $apiResponse, TokenService $tokenService)
    {
        parent::__construct($apiResponse);
        $this->tokenService = $tokenService;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Login $request
     * @return JsonResponse
     */
    public function login(Login $request): JsonResponse
    {
        if (!$token = auth()->attempt($request->only(['email', 'password', ]))) {
            return $this->apiResponse
                ->setMessage(__('messages.login.fail'))
                ->setFailureStatus(400)
                ->getResponse();
        }

        $user = User::findOrFail(auth()->id());

        return $this->apiResponse
            ->setMessage(__('messages.login.success'))
            ->setData([
                'token' => $token,
                'user' => $user,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return $this->apiResponse
            ->setMessage(__('messages.logout.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->apiResponse
            ->setData([
                'token' => auth()->refresh(),
            ])
            ->setSuccessStatus()
            ->getResponse();
    }
}
