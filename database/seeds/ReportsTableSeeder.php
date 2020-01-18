<?php

declare(strict_types=1);

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::inRandomOrder()->limit(15)->get() as $user) {
            factory(Report::class, 5)->create([
                'reported_by' => $user->id,
            ]);
        }
    }
}
