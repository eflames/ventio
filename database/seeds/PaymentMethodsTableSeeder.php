<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            ['name' => 'Crédito', 'identifier' => 'CRE', 'description' => 'Credito otorgado', 'created_by' => 1],
            ['name' => 'Deuda', 'identifier' => 'DED', 'description' => 'Deuda de cliente', 'created_by' => 1],
            ['name' => 'Efectivo', 'identifier' => 'CSH', 'description' => 'Pagos en el negocio en efectivo', 'created_by' => 1],
            ['name' => 'Punto de venta', 'identifier' => 'PTV', 'description' => 'Pago por el punto de venta', 'created_by' => 1],
            ['name' => 'Devolución', 'identifier' => 'DVN', 'description' => 'Devolución de dinero por devolución en venta', 'created_by' => 1],
        ]);
    }
}
