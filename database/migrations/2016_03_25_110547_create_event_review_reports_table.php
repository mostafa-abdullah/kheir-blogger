<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventReviewReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_review_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('review_id')->unsigned()->index();
            $table->foreign('review_id')->references('id')->on('event_reviews')->onDelete('cascade');
            /*
             * if a validator view a report its value will be 1 otherwise it will be 0
             */
            $table->integer('viewed')->defualt(0);

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
        Schema::drop('event_review_reports');
    }
}
