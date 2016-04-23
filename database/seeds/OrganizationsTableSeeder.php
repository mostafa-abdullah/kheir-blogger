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
        DB::table('organizations')->delete();
        DB::table('organizations')->insert([
            'id'       => '1',
            'name'     => 'Bdaya',
            'email'    => 'bdaya@gmail.com',
            'password' =>  bcrypt('123456'),
        ]);

        DB::table('organizations')->insert([
            'id'       => '2',
            'name'     => 'Nawwar',
            'email'    => 'nawwar@gmail.com',
            'password' =>  bcrypt('123456'),
        ]);

        DB::table('organizations')->insert([
            'id'       => '3',
            'name'     => 'AYB',
            'email'    => 'ayb@gmail.com',
            'password' =>  bcrypt('123456'),
        ]);
    }
}
