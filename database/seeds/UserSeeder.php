<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('admin'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0001',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0002',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0003',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0004',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0005',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'TECH-0006',
            'email' => '',
            'type' => 1,
            'password' => bcrypt('password'),
        ]);
    }
}
