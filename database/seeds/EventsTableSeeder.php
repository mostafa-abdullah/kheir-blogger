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
        DB::table('events')->delete();
        DB::table('events')->insert([
            'id'              => '1',
            'name'            => 'BigEvent',
            'description'     => 'Biggest event in GUC',
            'organization_id' => '1',
        ]);

         DB::table('events')->insert([
             'id'              => '2',
             'name'            => 'You Shall Not Pass',
             'description'     => 'Don\'t fear C7',
             'organization_id' => '2',
        ]);

        DB::table('events')->insert([
            'id'              => '3',
            'name'            => 'Avlexr',
            'description'     => 'Fear C7',
            'organization_id' => '1',
       ]);

    }
}
