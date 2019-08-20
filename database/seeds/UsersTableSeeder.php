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
        DB::table('users')->updateOrInsert(
        [
          'email' => 'tony@hotcookiebakery.com'
        ],
        [
          'email' => 'tony@hotcookiebakery.com',
          'name' => 'Tony Roug',
          'password' => Hash::make('TonyHotCookie1234')
        ]);
    }
}
