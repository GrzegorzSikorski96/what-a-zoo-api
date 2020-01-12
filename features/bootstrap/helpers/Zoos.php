<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\ZooCreator;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Requesting
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
}
