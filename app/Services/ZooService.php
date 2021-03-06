<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FeedAction;
use App\Models\User;
use App\Models\Zoo;
use Exception;
use Illuminate\Support\Collection;

/**
 * Class ZooService
 * @package App\Services
 */
class ZooService extends BaseService
{
    /**
     * @param int $zooId
     * @return Zoo
     */
    public function zoo(int $zooId): Zoo
    {
        $zoo = Zoo::with('animals')->findOrFail($zooId);
        $zoo['averageRating'] = $zoo->averageRating();

        return $zoo;
    }

    /**
     * @return Collection
     */
    public function zoos(): Collection
    {
        $zoos = Zoo::with('animals')->get();

        foreach ($zoos as $zoo) {
            $zoo['averageRating'] = $zoo->averageRating();
        }

        return $zoos;
    }

    /**
     * @param int $zooId
     * @return array
     */
    public function zooWithReviews(int $zooId): array
    {
        $zoo = $this->zoo($zooId);

        return [
            'zoo' => $zoo,
            'reviews' => $zoo->reviews()->with('author')->get(),
        ];
    }

    /**
     * @param array $data
     * @return Zoo
     */
    public function create(array $data): Zoo
    {
        $zoo = new Zoo($data);
        $zoo->save();

        return $zoo;
    }

    /**
     * @param int $zooId
     * @throws Exception
     */
    public function remove(int $zooId): void
    {
        $zoo = $this->zoo($zooId);
        $zoo->delete();
    }

    /**
     * @param int $userId
     * @param int $zooId
     * @return bool
     */
    public function isVisited(int $userId, int $zooId): bool
    {
        $user = User::findOrFail($userId);

        return $user->visitedZoos()->where('zoo_id', $zooId)->exists();
    }

    /**
     * @param int $zooId
     * @param int $userId
     */
    public function visit(int $zooId, int $userId): void
    {
        $user = User::findOrFail($userId);
        $zoo = $this->zoo($zooId);

        if (!$zoo->isVisited()) {
            $user->visitedZoos()->syncWithoutDetaching($zoo);
            $this->feedService->addFeed($userId, $zooId, FeedAction::VISIT);
        }
    }

    /**
     * @param int $zooId
     * @param int $userId
     */
    public function unVisit(int $zooId, int $userId): void
    {
        $user = User::findOrFail($userId);
        $zoo = $this->zoo($zooId);

        $user->visitedZoos()->detach($zoo);

        $this->feedService->removeFeed($userId, $zooId, FeedAction::VISIT);
    }

    /**
     * @return Collection
     */
    public function recommended(): Collection
    {
        $zoos = $this->zoos();

        return $zoos->sortByDesc('averageRating')->take(3);
    }
}
