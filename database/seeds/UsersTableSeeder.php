<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'password' => bcrypt('123456'),
            'role'=>'8',
        ]);

        DB::table('users')->insert([
            'first_name' => 'mostafa',
            'email' => 'mostafe@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'esraa',
            'email' => 'esraa@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
