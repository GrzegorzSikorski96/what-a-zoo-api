<?php

declare(strict_types=1);

use App\Models\FeedAction;
use Illuminate\Database\Seeder;

/**
 * Class FeedActionsTableSeeder
 */
class FeedActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            FeedAction::VISIT => 'odwiedził zoo',
            FeedAction::ADD_REVIEW => 'dodał opinię',
        ];

        foreach ($actions as $key => $value) {
            FeedAction::firstOrCreate([
                'id' => $key,
                'action' => $value,
            ]);
        }
    }
}
