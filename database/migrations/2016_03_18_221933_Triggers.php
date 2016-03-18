<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Triggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('organization_reviews', function (Blueprint $table) {
        });


        DB::unprepared('
        CREATE TRIGGER UpdateOrganizationReviewIn AFTER INSERT ON `organization_reviews` FOR EACH ROW
        BEGIN
         UPDATE organizations SET rate = (SELECT AVG(rate) FROM organization_reviews ) WHERE id = NEW.organization_id;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER UpdateOrganizationReviewDel AFTER DELETE ON `organization_reviews` FOR EACH ROW
        BEGIN
         UPDATE organizations SET rate = (SELECT AVG(rate) FROM organization_reviews ) WHERE id = OLD.organization_id;
        END
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER UpdateOrganizationRateDel ');
        DB::unprepared('DROP TRIGGER UpdateOrganizationRateIn');

    }
}
