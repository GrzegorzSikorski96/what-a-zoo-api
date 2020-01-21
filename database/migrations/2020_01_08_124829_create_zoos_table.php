<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoos', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->float('latitude', 11, 7);
            $table->float('longitude', 11, 7);
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('wiki_link')->nullable();
            $table->string('webpage_link')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('zoos', function (Blueprint $table): void {
            $table->dropIfExists();
        });
    }
}
