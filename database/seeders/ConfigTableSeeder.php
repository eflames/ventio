<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('config')->insertOrIgnore([
            ['key' => 'commission_percentage', 'value' => '0', 'description' => 'Porcentaje de comisión en vendedores', 'created_by' => 1],
            ['key' => 'exchange_rate', 'value' => '50000', 'description' => 'Valor de la tasa de cambio del U$D', 'created_by' => 1],
            ['key' => 'store_name', 'value' => 'Nombre de la tienda', 'description' => 'Nombre de la tienda', 'created_by' => 1],
            ['key' => 'store_email', 'value' => 'demo@demo.com', 'description' => 'Correo electrónico de la tienda', 'created_by' => 1],
        ]);
    }
}
