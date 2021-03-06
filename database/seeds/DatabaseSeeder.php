<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ReportActionsTableSeeder::class);
        $this->call(FeedActionsTableSeeder::class);
        $this->call(ZoosTableSeeder::class);
        $this->call(VisitedZoosTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(FriendsTableSeeder::class);
    }
}
