<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @param int $userId
     * @return User
     */
    public function user(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function visited(int $userId): Collection
    {
        $user = $this->user($userId);

        return $user->visitedZoos;
    }
}
