<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('notification_id')->unsigned()->index();
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('read') ;

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user_notifications');
    }
}
