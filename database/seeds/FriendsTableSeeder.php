<?php

declare(strict_types=1);

use App\Models\Friend;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all()->take(20) as $user) {
            foreach (User::all()->random(15) as $friend) {
                if ($friend->id != $user->id) {
                    Friend::FirstOrcreate([
                        'user_id' => $user->id,
                        'friend_id' => $friend->id,
                        'accepted_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
