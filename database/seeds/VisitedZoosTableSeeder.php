<?php

declare(strict_types=1);

use App\Models\FeedAction;
use App\Models\User;
use App\Models\Zoo;
use Illuminate\Database\Seeder;

class VisitedZoosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            foreach (Zoo::all()->random(random_int(3, 10)) as $zoo) {
                $user->visitedZoos()->syncWithoutDetaching($zoo);

                $user->feed()->create([
                    'action_id' => FeedAction::VISIT,
                    'zoo_id' => $zoo->id,
                ]);
            }
        }
    }
}
