<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatTriggerToUpdateEventRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_reviews', function (Blueprint $table) {
            //
        });

                DB::unprepared('
                CREATE TRIGGER UpdateEventReviewIn AFTER INSERT ON `event_reviews` FOR EACH ROW
                BEGIN
                 UPDATE events SET rate = (SELECT AVG(rate) FROM event_reviews ) WHERE id = NEW.event_id;
                END
                ');

                DB::unprepared('
                CREATE TRIGGER UpdateEventReviewDel AFTER DELETE ON `event_reviews` FOR EACH ROW
                BEGIN
                 UPDATE events SET rate = (SELECT AVG(rate) FROM event_reviews ) WHERE id = OLD.event_id;
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
        Schema::table('event_reviews', function (Blueprint $table) {
            //
            DB::unprepared('DROP TRIGGER UpdateEventReviewIn ');
            DB::unprepared('DROP TRIGGER UpdateEventReviewDel');

        });
    }
}
