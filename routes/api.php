<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth','isActive']], function (){
    Route::get('productos', 'ProductController@APIgetall')->name('api.products');
    Route::get('productos-stock', 'ProductController@APIgetallForSale')->name('api.productsforsale');
    Route::get('clientes', 'ClientController@APIgetall')->name('api.clients');
    Route::get('venta/getItems/{id}', 'SaleController@getSaleItems');
    Route::get('venta/getPayments/{id}', 'SaleController@getPayments');
    Route::get('venta/getTotal/{id}', 'SaleController@getSaleTotal');
    Route::get('venta/getBalance/{id}', 'SaleController@getBalance');
    Route::get('venta/getButtons/{id}', 'SaleController@getButtons');
    Route::get('venta/deleteItem/{id}', 'SaleController@deleteItem');
    Route::get('venta/deletePayment/{id}', 'SaleController@deletePaymentToSale');
    Route::get('venta/updateItem/{id}/{qty}', 'SaleController@updateItem');
    Route::get('venta/applyBalance/{id}', 'SaleController@applyBalance');
    Route::get('venta/giftItem/{id}', 'SaleController@giftItem');
    Route::get('cuentas/por-cobrar/{client_id}', 'LoanController@getClientLoans');
});