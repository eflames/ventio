<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the withRouting() method of bootstrap/app.php (middleware "web", prefijo "api")
| 
|
*/

Route::group(['middleware' => ['auth','isActive']], function (){
    // Route::post('ventas/all', [App\Http\Controllers\SaleController::class, 'getFilteredSales'])->name('api.getSales');
    // Route::post('stock/all', [App\Http\Controllers\StockController::class, 'getFilteredStock'])->name('api.getStock');
    // Route::post('clients/all', [App\Http\Controllers\ClientController::class, 'getFilteredClients'])->name('api.getClients');
    // Route::post('productos/all', [App\Http\Controllers\ProductController::class, 'getFilteredProducts'])->name('api.getProducts');
    Route::get('productos', [App\Http\Controllers\ProductController::class, 'APIgetall'])->name('api.products');
    Route::get('productos-stock', [App\Http\Controllers\ProductController::class, 'APIgetallForSale'])->name('api.productsforsale');
    Route::get('clientes', [App\Http\Controllers\ClientController::class, 'APIgetall'])->name('api.clients');
    Route::get('venta/getItems/{id}', [App\Http\Controllers\SaleController::class, 'getSaleItems']);
    Route::get('venta/getPayments/{id}', [App\Http\Controllers\SaleController::class, 'getPayments']);
    Route::get('venta/getTotal/{id}', [App\Http\Controllers\SaleController::class, 'getSaleTotal']);
    Route::get('venta/getBalance/{id}', [App\Http\Controllers\SaleController::class, 'getBalance']);
    Route::get('venta/getButtons/{id}', [App\Http\Controllers\SaleController::class, 'getButtons']);
    Route::get('venta/deleteItem/{id}', [App\Http\Controllers\SaleController::class, 'deleteItem']);
    Route::get('venta/deletePayment/{id}', [App\Http\Controllers\SaleController::class, 'deletePaymentToSale']);
    Route::get('venta/updateItem/{id}/{qty}', [App\Http\Controllers\SaleController::class, 'updateItem']);
    Route::get('venta/applyBalance/{id}', [App\Http\Controllers\SaleController::class, 'applyBalance']);
    Route::get('venta/giftItem/{id}', [App\Http\Controllers\SaleController::class, 'giftItem']);
    Route::get('cuentas/por-cobrar/{client_id}', [App\Http\Controllers\LoanController::class, 'getClientLoans']);
});