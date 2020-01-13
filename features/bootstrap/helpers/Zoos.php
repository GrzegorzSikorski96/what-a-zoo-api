<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\ZooCreator;
use App\Models\Zoo;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Zoos
 * @package BehatTests\helpers
 */
trait Zoos
{
    /**
     * @Given Zoo with id :zooId exist
     * @param int $zooId
     * @return void
     * @throws BindingResolutionException
     */
    public function zooWithIdExists(int $zooId): void
    {
        /** @var ZooCreator $creator */
        $creator = app()->make(ZooCreator::class);
        $creator->createOrReplaceZoo($zooId);
    }

    /**
     * @Given zoo with id :id not exists
     * @param int $zooId
     * @return void
     * @throws BindingResolutionException
     */
    public function zooWithIdNotExists(int $zooId): void
    {
        /** @var ZooCreator $creator */
        $creator = app()->make(ZooCreator::class);
        $creator->removeZooIfExists($zooId);
    }


    /**
     * @Given Zoo with id :id is visited
     * @param $id
     */
    public function zooWithIdIsVisited($id): void
    {
        $user = auth()->user();
        $zoo = Zoo::findOrFail($id);

        if (!$zoo->isVisited()) {
            $user->visitedZoos()->syncWithoutDetaching($zoo);
        }
    }
}
