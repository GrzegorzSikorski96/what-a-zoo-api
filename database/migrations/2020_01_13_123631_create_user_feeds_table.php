<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feeds', function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->bigInteger('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('feed_actions');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('zoo_id')->unsigned();
            $table->foreign('zoo_id')->references('id')->on('zoos');

            $table->unique(['user_id', 'zoo_id', 'action_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_feeds', function (Blueprint $table): void {
            $table->dropForeign('user_feeds_user_id_foreign');
            $table->dropForeign('user_feeds_zoo_id_foreign');
            $table->dropForeign('user_feeds_action_id_foreign');

            $table->dropIfExists();
        });
    }
}
