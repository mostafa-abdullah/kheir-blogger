<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
/*
|-------------------------------
| Notification Type Enumeration
|-------------------------------
|  1  => create_event
|  2  => update_event
|  3  => cancel_event
|  4  => post_in_event
|  5  => question_answered
|  6  => confim_event
|  7  => delete reviews
*/
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->text('description');
            $table->text('link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notifications');
    }
}
