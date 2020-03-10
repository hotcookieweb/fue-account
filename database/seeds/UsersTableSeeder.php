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
          'email' => 'admin',
          'name' => 'tony roug',
          'password' => Hash::make('root4hckit!'),
          'zones' => serialize(["other", "national", "castro-sf", "polk-sf"])
        ]);
        DB::table('users')->insert([
          'email' => 'castro-sf',
          'name' => 'staff castro',
          'password' => Hash::make('hotcookie4me!'),
          'zones' => serialize(["other", "national", "castro-sf"])
        ]);
        DB::table('users')->insert([
          'email' => 'polk-sf',
          'name' => 'staff polk',
          'password' => Hash::make('hotcookie4me!'),
          'zones' => serialize(["other", "national", "polk-sf"])
        ]);
    }
}
