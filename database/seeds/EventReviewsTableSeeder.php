<?php

use Illuminate\Database\Seeder;

class EventReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_reviews')->delete();
        DB::table('event_reviews')->insert([
            'id'       => '1',
            'user_id'     => '2',
            'event_id'    => '1',
            'review' =>  'great effort',
            'rating' => '5',
        ]);
    }
}
