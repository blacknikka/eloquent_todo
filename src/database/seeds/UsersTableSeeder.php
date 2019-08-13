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
            'name' => 'my-name',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
