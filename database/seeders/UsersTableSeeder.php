<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'name' => 'Ernesto Flames',
            'email' => 'ernesto@ernestoflames.com',
            'password' => bcrypt('123456'),
            'rol_id' => 1,
            'is_active' => 1,
            'created_by' => 1,
        ]);
    }
}
