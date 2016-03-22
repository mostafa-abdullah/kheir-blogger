<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{

    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
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
