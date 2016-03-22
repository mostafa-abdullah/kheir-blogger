<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            'name' => 'Bdaya',
            'email' => 'bdaya@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('organizations')->insert([
            'name' => 'Nawwar',
            'email' => 'nawwar@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('organizations')->insert([
            'name' => 'AYB',
            'email' => 'ayb@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
