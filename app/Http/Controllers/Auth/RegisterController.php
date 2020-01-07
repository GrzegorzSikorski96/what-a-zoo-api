<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /**
     * @param Register $request
     * @return JsonResponse
     */
    public function register(Register $request): JsonResponse
    {
        $this->create($request->only(['name', 'email', 'password', ]));

        return $this->registered()
            ?: $this->apiResponse
                ->setMessage(__('messages.registration.failed'))
                ->setFailureStatus(400)
                ->getResponse();
    }

    /**
     * @return JsonResponse
     */
    protected function registered(): JsonResponse
    {
        return $this->apiResponse
            ->setMessage(__('messages.registration.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
