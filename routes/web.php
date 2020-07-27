<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('home', function (){
//    return redirect('/');
//});
Route::group(['middleware' => ['auth','isActive']], function(){
    Route::get('/', 'HomeController@dashboard')->name('home');
    Route::get('home', 'HomeController@dashboard');
    Route::post('changeUser', 'HomeController@changeUser')->name('changeUser');
    Route::resource('categorias', 'ProductCategoryController')->names([
        'index' => 'categories.index',
        'update' => 'categories.update'
    ]);
    Route::resource('metodos-de-pago', 'PaymentMethodsController')->names([
        'index' => 'paymentMethods.index',
        'update' => 'paymentMethods.update'
        ]);
    Route::resource('almacenes', 'WarehouseController')->names([
        'index' => 'warehouses.index',
        'update' => 'warehouses.update'
    ]);
    Route::resource('configuracion/avanzado', 'ConfigController')->names([
        'index' => 'config.index',
        'store' => 'config.store'
    ]);
    Route::post('configuracion/avanzado/update', 'ConfigController@update')->name('config.update');
    Route::get('configuracion/general', 'ConfigController@general')->name('config.general');
    Route::post('configuracion/general', 'ConfigController@setVar')->name('config.setVar');
    Route::post('configuracion/set-store', 'ConfigController@setStore')->name('config.setStore');
    Route::post('configuracion/set-image', 'ConfigController@setImage')->name('config.setImage');
    Route::post('configuracion/maintenance', 'ConfigController@maintenance')->name('config.maintenance');
    Route::get('almacenes/default/{id}/{option}', 'WarehouseController@changeDefault')->name('warehouse.default');
    Route::resource('usuarios/permisos', 'RolController')->names([
        'index' => 'roles.list',
        'create' => 'roles.create',
        'edit' => 'roles.edit'
    ]);
    Route::resource('usuarios', 'UserController')->names([
        'index' => 'users.list',
        'create' => 'users.create',
        'edit' => 'users.edit'
        ]);
    Route::get('clients-dt', 'ClientController@getClients');
    Route::post('clientes/fast', 'ClientController@fastStore');
    Route::get('cliente/{id_number}', 'ClientController@details')->name('client.details');
    Route::get('cliente/notificar/{id}', 'ClientController@notifyClient')->name('client.notify');
    Route::resource('clientes', 'ClientController')->names([
        'index' => 'clients.list',
        'create' => 'clients.create',
        'edit' => 'clients.edit'
        ]);
    Route::post('productos/csv-import', 'ProductController@importCSV');
    Route::resource('productos', 'ProductController')->names([
        'index' => 'products.list',
        'create' => 'products.create',
        'edit' => 'products.edit'
        ]);
    Route::get('productos/create/{fs}', 'ProductController@create')->name('products.createfs');
    Route::get('products-dt', 'ProductController@getProducts');
    Route::post('stock/csv-import', 'StockController@importCSV');
    Route::post('stock/editPrice', 'StockController@editPrice');
    Route::post('stock/addQty', 'StockController@addQty');
    Route::post('stock/transfer', 'StockController@transfer');
    Route::get('stock/minimo', 'StockController@listMinStock')->name('stock.listMinStock');
    Route::get('stock/descargar', 'StockController@downloadStock')->name('stock.report');
    Route::get('stock/descargar/{slug}', 'StockController@downloadFilteredStock')->name('stock.reportFiltered');
    Route::get('stock/log', 'StockController@showLog')->name('stock.log');
    Route::get('stock/log/filtrado', 'StockController@showLogFiltered')->name('stock.filter');
    Route::resource('stock', 'StockController')->names([
        'index' => 'stock.list',
        'create' => 'stock.create',
        'edit' => 'stock.edit',
        'store' => 'stock.store',
        'update' => 'stock.update',
        ]);
    Route::get('stock-dt', 'StockController@getStock');
    Route::get('stock-dt/{slug}', 'StockController@getStockFiltered');
    Route::get('stock/almacen/{slug}', 'StockController@index')->name('stock.filtered');
    Route::post('stock/min-stock', 'StockController@setMinStock')->name('stock.setMinStock');
    Route::get('stock/min-stock/pdf', 'ReportController@generateMinStockPdf')->name('stock.generateMinStockPdf');
    Route::get('venta/{id}/edit', 'SaleController@sale')->name('sale.edit');
    Route::post('venta/delete/{id}', 'SaleController@deleteSale');
    Route::get('venta/{id}', 'SaleController@viewSale')->name('sale.view');
    Route::post('ventas/create', 'SaleController@newSale');
    Route::post('venta/eliminar', 'SaleController@deleteSale');
    Route::post('venta/addItem', 'SaleController@addItemToSale')->name('sale.additem');
    Route::post('venta/addPayment', 'SaleController@addPaymentToSale')->name('sale.addPayment');
    Route::get('venta/addAllPayment/{saleId}/{methodId}', 'SaleController@addAllPaymentToSale')->name('sale.addAllPayment');
    Route::post('venta/procSale', 'SaleController@procSale')->name('sale.procSale');
    Route::post('venta/changeItemPrice', 'SaleController@changeItemPrice')->name('sale.changeItemPrice');
    Route::post('venta/changeItemPriceFull', 'SaleController@changeItemPriceFull')->name('sale.changeItemPriceFull');
    Route::post('venta/returnItem', 'SaleController@returnItem')->name('sale.return');
    Route::get('ventas', 'SaleController@sales')->name('sales.list');
    Route::get('ventas/cambiar-almacen/{id}', 'SaleController@changeDefault')->name('sales.changeDefault');
    Route::get('ventas-dt', 'SaleController@getSales')->name('sales.list-dt');
    Route::get('cuentas/por-pagar', 'DepositController@list')->name('credits.list');
    Route::post('cuentas/por-pagar', 'DepositController@create')->name('credits.create');
    Route::post('cuentas/por-pagar/addAmount', 'DepositController@addAmount')->name('credits.addAmount');
    Route::delete('cuentas/por-pagar/{id}', 'DepositController@destroy')->name('credits.delete');
    Route::get('cuentas/por-cobrar', 'LoanController@list')->name('loans.list');
    Route::post('cuentas/por-cobrar', 'LoanController@addAmount')->name('loans.addAmount');
    Route::post('cuentas/por-cobrar/new', 'LoanController@create')->name('loans.create');
    Route::post('cuentas/por-cobrar/addPayment', 'LoanController@addPayment')->name('loans.payment');
    Route::delete('cuentas/por-cobrar/{id}', 'LoanController@destroy')->name('loans.delete');
    Route::get('cuentas/por-cobrar/getLog/{id}', 'LoanController@getPayments')->name('loans.payments');
    Route::get('cuentas/por-cobrar/deletePayment/{id}', 'LoanController@deletePayment')->name('loans.delPayment');
    Route::get('cuentas/por-cobrar/close/{id}', 'LoanController@closeLoan')->name('loans.close');
    Route::resource('cuentas/gastos', 'ExpenseController')->names([
        'index' => 'expenses.list',
        'store' => 'expenses.store',
        'update' => 'expenses.update'
    ]);
    Route::get('reportes', 'ReportController@list')->name('reports.list');
    Route::post('reporte/por-fecha', 'ReportController@generateSalesByDate')->name('report.byDate');
    Route::post('reporte/por-fecha-pdf', 'ReportController@generateSalesByDatePdf')->name('report.byDatePdf');
    Route::post('reporte/por-cliente-pdf', 'ReportController@generateSaleByClientPdf')->name('report.byClientPdf');
    Route::post('reporte/por-cliente', 'ReportController@generateSaleByClient')->name('report.byClient');
    Route::post('reporte/por-producto-pdf', 'ReportController@generateByProductPdf')->name('report.byProductPdf');
    Route::post('reporte/por-producto', 'ReportController@generateByProduct')->name('report.byProduct');
    Route::get('reporte/por-credito-pdf', 'ReportController@generateByCreditPdf')->name('report.byCreditPdf');
    Route::get('reporte/por-credito', 'ReportController@generateByCredit')->name('report.byCredit');
    Route::post('reporte/por-bs-pdf', 'ReportController@generateByBsPdf')->name('report.byBsPdf');
    Route::post('reporte/por-bs', 'ReportController@generateByBs')->name('report.byBs');
    Route::post('reporte/por-tipo-pdf', 'ReportController@generateByTypePdf')->name('report.byTypePdf');
    Route::post('reporte/por-tipo', 'ReportController@generateByType')->name('report.byType');
    Route::post('reporte/por-gastos-pdf', 'ReportController@generateByExpensePdf')->name('report.byExpensePdf');
    Route::post('reporte/por-gastos', 'ReportController@generateByExpense')->name('report.byExpense');
    Route::post('reporte/por-ganancia-pdf', 'ReportController@generateByProfitPdf')->name('report.byProfitPdf');
    Route::post('reporte/por-ganancia', 'ReportController@generateByProfit')->name('report.byProfit');
    Route::post('reporte/comisiones-pdf', 'ReportController@generateByCommissionPdf')->name('report.byCommissionPdf');
    Route::post('reporte/comisiones', 'ReportController@generateByCommission')->name('report.byCommission');
    Route::post('reporte/categoria', 'ReportController@generateByCategory')->name('report.byCategory');
    Route::post('reporte/categoria-pdf', 'ReportController@generateByCategoryPdf')->name('report.byCategoryPdf');
    Route::post('reporte/stock', 'ReportController@generateByStock')->name('report.byStock');
    Route::get('reporte/stock-pdf', 'ReportController@generateByStockPdf')->name('report.byStockPdf');
    Route::post('reporte/devoluciones-pdf', 'ReportController@generateByReturnPdf')->name('report.byReturnPdf');
    Route::post('reporte/devoluciones', 'ReportController@generateByReturn')->name('report.byReturn');
    Route::post('reporte/cambios-log', 'ReportController@generateByStockLog')->name('report.byStockLog');
    Route::post('reporte/cambios-log-pdf', 'ReportController@generateByStockLogPdf')->name('report.byStockLogPdf');
    Route::get('miperfil', 'HomeController@profile')->name('profile.edit');
    Route::post('miperfil', 'HomeController@storeProfile')->name('profile.store');
    Route::get('sistema', 'SystemController@index')->name('system.index');
    Route::get('sistema/backup-db', 'SystemController@dbbackup')->name('system.db');
    Route::get('sistema/export-to-woocommerce', 'SystemController@exportToWoocommerce')->name('system.woo');
    Route::post('sistema/license', 'SystemController@setLicense')->name('system.license');
    Route::get('acerca-de-ventio', 'HomeController@about')->name('system.about');


});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('validHash');
Route::post('login', 'Auth\LoginController@login')->middleware('validHash');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('license', 'SystemController@showLicenseForm')->name('licenseForm');
Route::post('license', 'SystemController@installLicense')->name('installLicense');
