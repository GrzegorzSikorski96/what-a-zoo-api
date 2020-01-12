<?php

declare(strict_types=1);

namespace App\Creators;

use App\Models\Zoo;

/**
 * Class ZooCreator
 * @package Sms\Creators
 */
class ZooCreator
{
    /**
     * @param int $zooId
     * @return void
     */
    public function createOrReplaceZoo(int $zooId): void
    {
        $zoo = Zoo::withTrashed()->firstOrCreate(
            ['id' => $zooId],
            [
                'name' => 'testZooName',
                'latitude' => 51.204491,
                'longitude' => 16.159241,
            ]
        );

        $zoo->deleted_at = null;

        $zoo->save();
    }

    /**
     * @param int $zooId
     * @return void
     */
    public function removeZooIfExists(int $zooId): void
    {
        Zoo::findOrFail($zooId)->delete();
    }
}
