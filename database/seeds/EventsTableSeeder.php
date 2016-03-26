<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
          'name' => 'BigEvent',
          'organization_id' => '1',
        ]);

         DB::table('events')->insert([
          'name' => 'You Shall Not Pass',
          'organization_id' => '2',
        ]);

    }
}
