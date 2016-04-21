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
        DB::table('users')->delete();
        DB::table('users')->insert([
            'id'         => '1',
            'first_name' => 'ahmad',
            'last_name'  => 'elsagheer',
            'email'      => 'ahmad@gmail.com',
            'password'   =>  bcrypt('123456'),
            'role'       => '8',
        ]);

        DB::table('users')->insert([
            'id'         => '2',
            'first_name' => 'mostafa',
            'last_name'  => 'abdullah',
            'email'      => 'mostafe@gmail.com',
            'password'   =>  bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'id'         => '3',
            'first_name' => 'esraa',
            'last_name'  => 'salah',
            'email'      => 'esraa@gmail.com',
            'password'   =>  bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'id'         => '4',
            'first_name' => 'Baher',
            'last_name'  => 'Abdo',
            'email'      => 'bebo@gmail.com',
            'password'   =>  bcrypt('123456'),
            'role'       => '5',
        ]);
    }
}
