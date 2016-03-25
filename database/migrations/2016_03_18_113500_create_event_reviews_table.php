<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventReviewsTable extends Migration
{

    public function up()
    {
        Schema::create('event_reviews', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');


            $table->text('review');
            $table->integer('rate');
            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER ins_event_reviews AFTER INSERT ON `event_reviews`
                FOR EACH ROW
                    BEGIN
                        UPDATE events
                        SET rate = (SELECT AVG(rate) FROM event_reviews WHERE id = NEW.event_id)
                        WHERE id = NEW.event_id;
                    END
        ");

        DB::unprepared("
            CREATE TRIGGER del_event_reviews AFTER DELETE ON `event_reviews`
                FOR EACH ROW
                    BEGIN
                        UPDATE organizations
                            SET rate = (SELECT AVG(rate) FROM event_reviews WHERE id = OLD.event_id)
                        WHERE id = OLD.event_id;
                    END
        ");

    }

    public function down()
    {
        Schema::drop('event_reviews');
    }
}
