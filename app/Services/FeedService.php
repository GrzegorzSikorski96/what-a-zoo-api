<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Feed;
use App\Models\FeedAction;
use App\Models\User;
use App\Models\Zoo;
use Illuminate\Support\Collection;

/**
 * Class FeedService
 * @package App\Services
 */
class FeedService
{
    /**
     * @param int $userId
     * @param int $zooId
     * @param int $actionId
     */
    public function addFeed(int $userId, int $zooId, int $actionId): void
    {
        $user = User::findOrFail($userId);
        FeedAction::findOrFail($actionId);
        Zoo::findOrFail($zooId);

        $user->feed()->create([
            'action_id' => $actionId,
            'zoo_id' => $zooId,
        ]);
    }

    /**
     * @param int $userId
     * @param int $zooId
     * @param int $actionId
     */
    public function removeFeed(int $userId, int $zooId, int $actionId): void
    {
        if (Feed::where('user_id', $userId)->where('zoo_id', $zooId)->where('action_id', $actionId)->first()) {
            $feed = Feed::where('user_id', $userId)->where('zoo_id', $zooId)->where('action_id', $actionId)->first();
            $feed->delete();
        }
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function userFeed(int $userId): Collection
    {
        $user = User::findOrFail($userId);

        return $user->feed;
    }

    /**
     * @return Collection
     */
    public function loggedUserFeed(): Collection
    {
        $user = auth()->user();
        $friendsIds = $user->friends->pluck('id')->toArray();
        $friendsIds[] = $user->id;

        return Feed::whereIn('user_id', $friendsIds)->get();
    }
}
