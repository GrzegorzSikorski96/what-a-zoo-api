<?php

declare(strict_types=1);

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
        factory(Zoo::class, 30)->create();
    }
}
