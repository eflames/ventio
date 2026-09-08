<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sale_status')->insertOrIgnore([
            ['name' => 'Incompleto'],
            ['name' => 'Cerrado'],
        ]);
    }
}
