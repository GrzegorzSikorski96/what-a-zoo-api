<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class FriendService
 * @package App\Services
 */
class FriendService
{
    /**
     * @return Collection
     */
    public function friends(): Collection
    {
        return auth()->user()->friends;
    }

    /**
     * @param int $friendId
     */
    public function sendFriendRequest(int $friendId): void
    {
        $friend = User::findOrFail($friendId);

        if (!Friend::whereIn('user_id', [auth()->id(), $friendId])->whereIn('friend_id', [auth()->id(), $friendId])->first()) {
            Friend::FirstOrcreate([
                'user_id' => auth()->id(),
                'friend_id' => $friend->id,
            ]);
        } else {
            throw new AccessDeniedHttpException();
        }
    }

    /**
     * @param int $userId
     */
    public function acceptFriendRequest(int $userId): void
    {
        $friendRecord = Friend::where('friend_id', auth()->id())->where('user_id', $userId)->firstOrFail();
        $friendRecord->accepted_at = Carbon::now();

        $friendRecord->save();
    }

    /**
     * @param int $userId
     */
    public function rejectFriendRequest(int $userId): void
    {
        $friendRecord = Friend::where('friend_id', auth()->id())->where('user_id', $userId)->firstOrFail();
        $friendRecord->delete();
    }

    /**
     * @param int $friendId
     */
    public function removeFriend(int $friendId): void
    {
        $friendRecord = Friend::whereIn('user_id', [$friendId, auth()->id()])->whereIn('friend_id', [$friendId, auth()->id()])->firstOrFail();
        $friendRecord->delete();
    }
}
