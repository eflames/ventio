<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config')->insert([
            ['key' => 'commission_percentage',    'value' => '0',                      'description' => 'Porcentaje de comisión en vendedores', 'created_by' => 1],
            ['key' => 'exchange_rate',            'value' => '50000',                  'description' => 'Valor de la tasa de cambio del U$D',   'created_by' => 1],
            ['key' => 'store_name',               'value' => 'Nombre de la tienda',    'description' => 'Nombre de la tienda',                  'created_by' => 1],
            ['key' => 'store_email',              'value' => 'demo@demo.com',          'description' => 'Correo electrónico de la tienda',      'created_by' => 1]

        ]);
    }
}
