<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the withRouting() method of bootstrap/app.php which
| is assigned the "web" middleware group. Enjoy building your app!
|
*/
//Route::get('home', function (){
//    return redirect('/');
//});
Route::group(['middleware' => ['auth','isActive']], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');
    Route::get('home', [App\Http\Controllers\HomeController::class, 'dashboard']);
    Route::post('changeUser', [App\Http\Controllers\HomeController::class, 'changeUser'])->name('changeUser');
    Route::resource('categorias', App\Http\Controllers\ProductCategoryController::class)->names([
        'index' => 'categories.index',
        'update' => 'categories.update'
    ]);
    Route::resource('metodos-de-pago', App\Http\Controllers\PaymentMethodsController::class)->names([
        'index' => 'paymentMethods.index',
        'update' => 'paymentMethods.update'
        ]);
    Route::resource('almacenes', App\Http\Controllers\WarehouseController::class)->names([
        'index' => 'warehouses.index',
        'update' => 'warehouses.update'
    ]);
    Route::resource('configuracion/avanzado', App\Http\Controllers\ConfigController::class)->names([
        'index' => 'config.index',
        'store' => 'config.store'
    ]);
    Route::post('configuracion/avanzado/update', [App\Http\Controllers\ConfigController::class, 'update'])->name('config.update');
    Route::get('configuracion/general', [App\Http\Controllers\ConfigController::class, 'general'])->name('config.general');
    Route::post('configuracion/general', [App\Http\Controllers\ConfigController::class, 'setVar'])->name('config.setVar');
    Route::post('configuracion/set-store', [App\Http\Controllers\ConfigController::class, 'setStore'])->name('config.setStore');
    Route::post('configuracion/set-image', [App\Http\Controllers\ConfigController::class, 'setImage'])->name('config.setImage');
    Route::post('configuracion/maintenance', [App\Http\Controllers\ConfigController::class, 'maintenance'])->name('config.maintenance');
    Route::get('almacenes/default/{id}/{option}', [App\Http\Controllers\WarehouseController::class, 'changeDefault'])->name('warehouse.default');
    Route::resource('usuarios/permisos', App\Http\Controllers\RolController::class)->names([
        'index' => 'roles.list',
        'create' => 'roles.create',
        'edit' => 'roles.edit'
    ]);
    Route::resource('usuarios', App\Http\Controllers\UserController::class)->names([
        'index' => 'users.list',
        'create' => 'users.create',
        'edit' => 'users.edit'
        ]);
    Route::get('clients-dt', [App\Http\Controllers\ClientController::class, 'getClients']);
    Route::post('clientes/fast', [App\Http\Controllers\ClientController::class, 'fastStore']);
    Route::get('cliente/{id_number}', [App\Http\Controllers\ClientController::class, 'details'])->name('client.details');
    Route::get('cliente/notificar/{id}', [App\Http\Controllers\ClientController::class, 'notifyClient'])->name('client.notify');
    Route::resource('clientes', App\Http\Controllers\ClientController::class)->names([
        'index' => 'clients.list',
        'create' => 'clients.create',
        'edit' => 'clients.edit'
        ]);
    Route::post('productos/csv-import', [App\Http\Controllers\ProductController::class, 'importCSV']);
    Route::resource('productos', App\Http\Controllers\ProductController::class)->names([
        'index' => 'products.list',
        'create' => 'products.create',
        'edit' => 'products.edit'
        ]);
    Route::get('productos/create/{fs}', [App\Http\Controllers\ProductController::class, 'create'])->name('products.createfs');
    Route::get('products-dt', [App\Http\Controllers\ProductController::class, 'getProducts']);
    Route::post('stock/csv-import', [App\Http\Controllers\StockController::class, 'importCSV']);
    Route::post('stock/editPrice', [App\Http\Controllers\StockController::class, 'editPrice']);
    Route::post('stock/addQty', [App\Http\Controllers\StockController::class, 'addQty']);
    Route::post('stock/transfer', [App\Http\Controllers\StockController::class, 'transfer']);
    Route::get('stock/minimo', [App\Http\Controllers\StockController::class, 'listMinStock'])->name('stock.listMinStock');
    Route::get('stock/descargar', [App\Http\Controllers\StockController::class, 'downloadStock'])->name('stock.report');
    Route::get('stock/descargar/{slug}', [App\Http\Controllers\StockController::class, 'downloadFilteredStock'])->name('stock.reportFiltered');
    Route::get('stock/log', [App\Http\Controllers\StockController::class, 'showLog'])->name('stock.log');
    Route::get('stock/log/filtrado', [App\Http\Controllers\StockController::class, 'showLogFiltered'])->name('stock.filter');
    Route::resource('stock', App\Http\Controllers\StockController::class)->names([
        'index' => 'stock.list',
        'create' => 'stock.create',
        'edit' => 'stock.edit',
        'store' => 'stock.store',
        'update' => 'stock.update',
        ]);
    Route::get('stock-dt', [App\Http\Controllers\StockController::class, 'getStock']);
    Route::get('stock-dt/{slug}', [App\Http\Controllers\StockController::class, 'getStockFiltered']);
    Route::get('stock/almacen/{slug}', [App\Http\Controllers\StockController::class, 'index'])->name('stock.filtered');
    Route::post('stock/min-stock', [App\Http\Controllers\StockController::class, 'setMinStock'])->name('stock.setMinStock');
    Route::get('stock/min-stock/pdf', [App\Http\Controllers\ReportController::class, 'generateMinStockPdf'])->name('stock.generateMinStockPdf');
    Route::get('venta/{id}/edit', [App\Http\Controllers\SaleController::class, 'sale'])->name('sale.edit');
    Route::post('venta/delete/{id}', [App\Http\Controllers\SaleController::class, 'deleteSale']);
    Route::get('venta/{id}', [App\Http\Controllers\SaleController::class, 'viewSale'])->name('sale.view');
    Route::post('ventas/create', [App\Http\Controllers\SaleController::class, 'newSale']);
    Route::post('venta/eliminar', [App\Http\Controllers\SaleController::class, 'deleteSale']);
    Route::post('venta/addItem', [App\Http\Controllers\SaleController::class, 'addItemToSale'])->name('sale.additem');
    Route::post('venta/addPayment', [App\Http\Controllers\SaleController::class, 'addPaymentToSale'])->name('sale.addPayment');
    Route::get('venta/addAllPayment/{saleId}/{methodId}', [App\Http\Controllers\SaleController::class, 'addAllPaymentToSale'])->name('sale.addAllPayment');
    Route::post('venta/procSale', [App\Http\Controllers\SaleController::class, 'procSale'])->name('sale.procSale');
    Route::post('venta/changeItemPrice', [App\Http\Controllers\SaleController::class, 'changeItemPrice'])->name('sale.changeItemPrice');
    Route::post('venta/changeItemPriceFull', [App\Http\Controllers\SaleController::class, 'changeItemPriceFull'])->name('sale.changeItemPriceFull');
    Route::post('venta/returnItem', [App\Http\Controllers\SaleController::class, 'returnItem'])->name('sale.return');
    Route::get('ventas', [App\Http\Controllers\SaleController::class, 'sales'])->name('sales.list');
    Route::get('ventas/cambiar-almacen/{id}', [App\Http\Controllers\SaleController::class, 'changeDefault'])->name('sales.changeDefault');
    Route::get('ventas-dt', [App\Http\Controllers\SaleController::class, 'getSales'])->name('sales.list-dt');
    Route::get('cuentas/por-pagar', [App\Http\Controllers\DepositController::class, 'list'])->name('credits.list');
    Route::post('cuentas/por-pagar', [App\Http\Controllers\DepositController::class, 'create'])->name('credits.create');
    Route::post('cuentas/por-pagar/addAmount', [App\Http\Controllers\DepositController::class, 'addAmount'])->name('credits.addAmount');
    Route::delete('cuentas/por-pagar/{id}', [App\Http\Controllers\DepositController::class, 'destroy'])->name('credits.delete');
    Route::get('cuentas/por-cobrar', [App\Http\Controllers\LoanController::class, 'list'])->name('loans.list');
    Route::post('cuentas/por-cobrar', [App\Http\Controllers\LoanController::class, 'addAmount'])->name('loans.addAmount');
    Route::post('cuentas/por-cobrar/new', [App\Http\Controllers\LoanController::class, 'create'])->name('loans.create');
    Route::post('cuentas/por-cobrar/addPayment', [App\Http\Controllers\LoanController::class, 'addPayment'])->name('loans.payment');
    Route::delete('cuentas/por-cobrar/{id}', [App\Http\Controllers\LoanController::class, 'destroy'])->name('loans.delete');
    Route::get('cuentas/por-cobrar/getLog/{id}', [App\Http\Controllers\LoanController::class, 'getPayments'])->name('loans.payments');
    Route::get('cuentas/por-cobrar/deletePayment/{id}', [App\Http\Controllers\LoanController::class, 'deletePayment'])->name('loans.delPayment');
    Route::get('cuentas/por-cobrar/close/{id}', [App\Http\Controllers\LoanController::class, 'closeLoan'])->name('loans.close');
    Route::resource('cuentas/gastos', App\Http\Controllers\ExpenseController::class)->names([
        'index' => 'expenses.list',
        'store' => 'expenses.store',
        'update' => 'expenses.update'
    ]);
    Route::get('reportes', [App\Http\Controllers\ReportController::class, 'list'])->name('reports.list');
    Route::post('reporte/por-fecha', [App\Http\Controllers\ReportController::class, 'generateSalesByDate'])->name('report.byDate');
    Route::post('reporte/por-fecha-pdf', [App\Http\Controllers\ReportController::class, 'generateSalesByDatePdf'])->name('report.byDatePdf');
    Route::post('reporte/por-cliente-pdf', [App\Http\Controllers\ReportController::class, 'generateSaleByClientPdf'])->name('report.byClientPdf');
    Route::post('reporte/por-cliente', [App\Http\Controllers\ReportController::class, 'generateSaleByClient'])->name('report.byClient');
    Route::post('reporte/por-producto-pdf', [App\Http\Controllers\ReportController::class, 'generateByProductPdf'])->name('report.byProductPdf');
    Route::post('reporte/por-producto', [App\Http\Controllers\ReportController::class, 'generateByProduct'])->name('report.byProduct');
    Route::get('reporte/por-credito-pdf', [App\Http\Controllers\ReportController::class, 'generateByCreditPdf'])->name('report.byCreditPdf');
    Route::get('reporte/por-credito', [App\Http\Controllers\ReportController::class, 'generateByCredit'])->name('report.byCredit');
    Route::post('reporte/por-bs-pdf', [App\Http\Controllers\ReportController::class, 'generateByBsPdf'])->name('report.byBsPdf');
    Route::post('reporte/por-bs', [App\Http\Controllers\ReportController::class, 'generateByBs'])->name('report.byBs');
    Route::post('reporte/por-tipo-pdf', [App\Http\Controllers\ReportController::class, 'generateByTypePdf'])->name('report.byTypePdf');
    Route::post('reporte/por-tipo', [App\Http\Controllers\ReportController::class, 'generateByType'])->name('report.byType');
    Route::post('reporte/por-gastos-pdf', [App\Http\Controllers\ReportController::class, 'generateByExpensePdf'])->name('report.byExpensePdf');
    Route::post('reporte/por-gastos', [App\Http\Controllers\ReportController::class, 'generateByExpense'])->name('report.byExpense');
    Route::post('reporte/por-ganancia-pdf', [App\Http\Controllers\ReportController::class, 'generateByProfitPdf'])->name('report.byProfitPdf');
    Route::post('reporte/por-ganancia', [App\Http\Controllers\ReportController::class, 'generateByProfit'])->name('report.byProfit');
    Route::post('reporte/comisiones-pdf', [App\Http\Controllers\ReportController::class, 'generateByCommissionPdf'])->name('report.byCommissionPdf');
    Route::post('reporte/comisiones', [App\Http\Controllers\ReportController::class, 'generateByCommission'])->name('report.byCommission');
    Route::post('reporte/categoria', [App\Http\Controllers\ReportController::class, 'generateByCategory'])->name('report.byCategory');
    Route::post('reporte/categoria-pdf', [App\Http\Controllers\ReportController::class, 'generateByCategoryPdf'])->name('report.byCategoryPdf');
    Route::post('reporte/stock', [App\Http\Controllers\ReportController::class, 'generateByStock'])->name('report.byStock');
    Route::get('reporte/stock-pdf', [App\Http\Controllers\ReportController::class, 'generateByStockPdf'])->name('report.byStockPdf');
    Route::post('reporte/devoluciones-pdf', [App\Http\Controllers\ReportController::class, 'generateByReturnPdf'])->name('report.byReturnPdf');
    Route::post('reporte/devoluciones', [App\Http\Controllers\ReportController::class, 'generateByReturn'])->name('report.byReturn');
    Route::post('reporte/cambios-log', [App\Http\Controllers\ReportController::class, 'generateByStockLog'])->name('report.byStockLog');
    Route::post('reporte/cambios-log-pdf', [App\Http\Controllers\ReportController::class, 'generateByStockLogPdf'])->name('report.byStockLogPdf');
    Route::get('miperfil', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile.edit');
    Route::post('miperfil', [App\Http\Controllers\HomeController::class, 'storeProfile'])->name('profile.store');
    Route::get('sistema', [App\Http\Controllers\SystemController::class, 'index'])->name('system.index');
    Route::get('sistema/backup-db', [App\Http\Controllers\SystemController::class, 'dbbackup'])->name('system.db');
    Route::get('sistema/export-to-woocommerce', [App\Http\Controllers\SystemController::class, 'exportToWoocommerce'])->name('system.woo');
    Route::post('sistema/license', [App\Http\Controllers\SystemController::class, 'setLicense'])->name('system.license');
    Route::get('acerca-de-ventio', [App\Http\Controllers\HomeController::class, 'about'])->name('system.about');


});

// Authentication Routes...
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login')->middleware('validHash');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('validHash');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('license', [App\Http\Controllers\SystemController::class, 'showLicenseForm'])->name('licenseForm');
Route::post('license', [App\Http\Controllers\SystemController::class, 'installLicense'])->name('installLicense');
