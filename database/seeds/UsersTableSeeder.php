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
        \DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'demo',
            'email' => 'info@jobleads.com',
            'password' => bcrypt('demo123'),
        ]);
    }
}
