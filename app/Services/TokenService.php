<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Payload;

/**
 * Class TokenService
 * @package App\Services
 */
class TokenService extends JWTAuth
{
    /**
     * @param User $user
     * @return string
     */
    public function generateToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }

    /**
     * @return Payload
     * @throws JWTException
     */
    public function checkToken()
    {
        return $this->checkOrFail();
    }

    /**
     * @throws JWTException
     */
    public function deactivateToken(): void
    {
        JWTAuth::parseToken()->invalidate();
    }
}
