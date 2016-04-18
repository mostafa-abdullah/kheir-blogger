<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteersInEventsTable extends Migration
{

    public function up()
    {
        Schema::create('volunteers_in_events', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            /**
             * 1 => following
             * 2 => registered
             * 3 => attended
             * 4 => didin't attended
             */
            $table->integer('type')->unsigned();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('volunteers_in_events');
    }
}
