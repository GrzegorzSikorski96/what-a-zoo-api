<?php

declare(strict_types=1);

use App\Models\FeedAction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
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
            foreach ($user->visitedZoos as $zoo) {
                if (!$zoo->alreadyReviewed()) {
                    factory(Review::class)->create([
                        'user_id' => $user->id,
                        'zoo_id' => $zoo->id
                    ]);

                    $user->feed()->create([
                        'action_id' => FeedAction::ADD_REVIEW,
                        'zoo_id' => $zoo->id,
                    ]);
                }
            }
        }
    }
}
