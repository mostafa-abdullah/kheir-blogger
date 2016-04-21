<?php

use Illuminate\Database\Seeder;

class OrganizationReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organization_reviews')->delete();
        DB::table('organization_reviews')->insert([
            'id'       => '1',
            'user_id'     => '2',
            'organization_id'    => '1',
            'review' =>  'great effort',
            'rate' => '5',
        ]);
    }

}
