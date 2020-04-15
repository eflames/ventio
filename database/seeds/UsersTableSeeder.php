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
            'name' => 'Ernesto Flames',
            'email' => 'ernesto@grupotera.com.ve',
            'password' => bcrypt('123456'),
            'rol_id' => 1,
            'is_active' => 1,
            'created_by' => 1
        ]);
    }
}
