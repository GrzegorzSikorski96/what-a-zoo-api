<?php

declare(strict_types=1);

use App\Models\Animal;
use App\Models\Zoo;
use Illuminate\Database\Seeder;

class ZoosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = File::get("database/data/default_zoo_list.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            $zoo = Zoo::create([
                'name' => $object->name,
                'latitude' => floatval($object->latitude),
                'longitude' => floatval($object->longitude),
                'address' => $object->address,
                'description' => $object->description,
                'wiki_link' => $object->wiki_link,
                'webpage_link' => $object->webpage_link,
            ]);

            foreach ($object->animals as $animal) {
                Animal::create([
                    'name' => $animal,
                    'zoo_id' => $zoo->id
                ]);
            }
        }
    }
}
