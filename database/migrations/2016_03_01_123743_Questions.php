<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Questions', function (Blueprint $table){
            $table->increments('q_id')->unsigned()->index();    
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade');
            $table->integer('organization_id')->unsigned()->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->text('q_content');
            $table->text('ans_content');
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
        Schema::drop('Questions');
    }
}
