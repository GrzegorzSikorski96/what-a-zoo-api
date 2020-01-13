<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Zoo;
use Illuminate\Support\Collection;

/**
 * Class ZooService
 * @package App\Services
 */
class ZooService
{
    /**
     * @param int $zooId
     * @return Zoo
     */
    public function zoo(int $zooId): Zoo
    {
        return Zoo::findOrFail($zooId);
    }

    /**
     * @return Collection
     */
    public function zoos(): Collection
    {
        return Zoo::all();
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
            'reviews' => $zoo->reviews,
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
     * @throws \Exception
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
     */
    public function visit(int $zooId): void
    {
        $user = auth()->user();
        $zoo = $this->zoo($zooId);

        if (!$zoo->isVisited()) {
            $user->visitedZoos()->syncWithoutDetaching($zoo);
        }
    }

    /**
     * @param int $zooId
     */
    public function unVisit(int $zooId): void
    {
        $user = auth()->user();
        $zoo = $this->zoo($zooId);

        $user->visitedZoos()->detach($zoo);
    }
}
