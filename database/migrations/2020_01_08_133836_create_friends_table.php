<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->dateTime('accepted_at')->nullable();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('friend_id')->unsigned();
            $table->foreign('friend_id')->references('id')->on('users');

            $table->unique(['user_id', 'friend_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('friends', function (Blueprint $table): void {
            $table->dropForeign('friends_user_id_foreign');
            $table->dropForeign('friends_friend_id_foreign');

            $table->dropIfExists();
        });
    }
}
