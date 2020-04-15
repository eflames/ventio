<?php

use Illuminate\Database\Seeder;

class SaleStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sale_status')->insert([
            ['name' => 'Incompleto'],
            ['name' => 'Cerrado'],
        ]);
    }
}
