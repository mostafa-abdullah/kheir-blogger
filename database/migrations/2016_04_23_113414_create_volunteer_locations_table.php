<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_locations', function(Blueprint $table){

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('location_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')
                                      ->on('users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')
                                          ->on('locations')->onDelete('cascade');
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

        Schema::drop('volunteer_locations');
    }
}
