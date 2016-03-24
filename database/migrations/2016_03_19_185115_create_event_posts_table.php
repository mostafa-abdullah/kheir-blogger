<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('event_posts', function (Blueprint $table) {
        $table->increments('id');

        $table->integer('event_id')->unsigned()->index();
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

        $table->integer('organization_id')->unsigned()->index();
        $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

        $table->string('title');
        $table->text('description');

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
        Schema::drop('event_posts');
    }
}
