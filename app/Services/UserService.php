<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
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

    public function users(): Collection
    {
        return User::all();
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

    public function ban(int $userId): void
    {
        $user = User::findOrFail($userId);

        $user->blocked_at = Carbon::now();
        $user->save();
    }

    public function unBan(int $userId): void
    {
        $user = User::findOrFail($userId);

        $user->blocked_at = null;
        $user->save();
    }
}
