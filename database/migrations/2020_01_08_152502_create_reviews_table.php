<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('review')->nullable();
            $table->integer('rating')->unsigned();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('zoo_id')->unsigned();
            $table->foreign('zoo_id')->references('id')->on('zoos');

            $table->unique(['user_id', 'zoo_id']);

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
        Schema::table('reviews', function (Blueprint $table): void {
            $table->dropForeign('reviews_user_id_foreign');
            $table->dropForeign('reviews_zoo_id_foreign');

            $table->dropIfExists();
        });
    }
}
