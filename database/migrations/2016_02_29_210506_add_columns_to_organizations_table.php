<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::table('organizations', function ($table) {

       $table->string('slogan', 50)->nullable();
       $table->string('phone', 11)->nullable();
       $table->string('location', 100)->nullable();

     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('organizations', function ($table) {
          $table->dropColumn('slogan');
          $table->dropColumn('phone');
          $table->dropColumn('location');
      });
    }
}
