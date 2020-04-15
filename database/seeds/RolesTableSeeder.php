<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
                ['name' => 'Superadmin', 'p_sell' => 1, 'p_sales' => 1, 'p_s_inventory' => 1, 'p_e_inventory' => 1, 'p_s_clients' => 1, 'p_e_clients' => 1, 'p_s_credits' => 1, 'p_e_credits' => 1, 'p_reports' => 1, 'p_discount' => 1, 'p_users' => 1, 'p_config' => 1, 'created_by' => 1],
                ['name' => 'Admin',      'p_sell' => 1, 'p_sales' => 1, 'p_s_inventory' => 1, 'p_e_inventory' => 1, 'p_s_clients' => 1, 'p_e_clients' => 1, 'p_s_credits' => 1, 'p_e_credits' => 1, 'p_reports' => 1, 'p_discount' => 1, 'p_users' => 0, 'p_config' => 1, 'created_by' => 1],
                ['name' => 'Vendedor',   'p_sell' => 1, 'p_sales' => 1, 'p_s_inventory' => 1, 'p_e_inventory' => 1, 'p_s_clients' => 1, 'p_e_clients' => 1, 'p_s_credits' => 1, 'p_e_credits' => 0, 'p_reports' => 1, 'p_discount' => 0, 'p_users' => 0, 'p_config' => 0, 'created_by' => 1],
                ['name' => 'Consulta',   'p_sell' => 0, 'p_sales' => 1, 'p_s_inventory' => 1, 'p_e_inventory' => 0, 'p_s_clients' => 1, 'p_e_clients' => 0, 'p_s_credits' => 1, 'p_e_credits' => 0, 'p_reports' => 1, 'p_discount' => 0, 'p_users' => 0, 'p_config' => 0, 'created_by' => 1],
            ]);
    }
}
