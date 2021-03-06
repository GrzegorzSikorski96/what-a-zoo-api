<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitedZoosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visited_zoos', function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('zoo_id')->unsigned();
            $table->foreign('zoo_id')->references('id')->on('zoos')->onDelete('cascade');

            $table->unique(['user_id', 'zoo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('visited_zoos', function (Blueprint $table): void {
            $table->dropForeign('visited_zoos_user_id_foreign');
            $table->dropForeign('visited_zoos_zoo_id_foreign');

            $table->dropIfExists();
        });
    }
}
