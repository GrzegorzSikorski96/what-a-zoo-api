<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->dateTime('solved_at')->nullable();

            $table->bigInteger('review_id')->unsigned();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');

            $table->bigInteger('reported_by')->unsigned();
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('action_id')->unsigned()->nullable();
            $table->foreign('action_id')->references('id')->on('report_actions');

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
        Schema::table('reports', function (Blueprint $table): void {
            $table->dropForeign('reports_review_id_foreign');
            $table->dropForeign('reports_reported_by_foreign');
            $table->dropForeign('reports_action_id_foreign');

            $table->dropIfExists();
        });
    }
}
