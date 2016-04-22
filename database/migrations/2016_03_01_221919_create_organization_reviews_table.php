<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationReviewsTable extends Migration
{

    public function up()
    {
        Schema::create('organization_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('organization_id')->unsigned()->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

            $table->text('review');
            $table->integer('rate');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::unprepared("
            CREATE TRIGGER ins_organization_reviews AFTER INSERT ON `organization_reviews`
                FOR EACH ROW
                    BEGIN
                        UPDATE organizations
                        SET rate = (SELECT AVG(rate) FROM organization_reviews WHERE id = NEW.organization_id)
                        WHERE id = NEW.organization_id;
                    END
        ");

        DB::unprepared("
            CREATE TRIGGER del_organization_reviews AFTER DELETE ON `organization_reviews`
                FOR EACH ROW
                    BEGIN
                        UPDATE organizations
                            SET rate = (SELECT AVG(rate) FROM organization_reviews WHERE id = OLD.organization_id)
                        WHERE id = OLD.organization_id;
                    END
        ");
    }

    public function down()
    {
        Schema::drop('organization_reviews');
    }
}
