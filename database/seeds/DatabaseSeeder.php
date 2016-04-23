<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventReviewsTableSeeder::class);
        $this->call(OrganizationReviewsTableSeeder::class);        
        Model::reguard();
    }
}
