<?php

declare(strict_types=1);

use App\Models\ReportActions;
use Illuminate\Database\Seeder;

class ReportActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            ReportActions::RESTORE_REVIEW => 'przywrócenie opinii',
            ReportActions::REMOVE_REVIEW => 'usunięcie opinii',
            ReportActions::REMOVE_REVIEW_WITH_USER => 'usunięcie opinii oraz zablokowanie użytkownika'
        ];

        foreach ($actions as $key => $value) {
            ReportActions::firstOrCreate([
                'id' => $key,
                'action' => $value,
            ]);
        }
    }
}
