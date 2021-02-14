<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use App\Models\StockLog;

class ReportController extends Controller
{
    use SEO;

    public function list()
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reportes');
            $data['sellers'] = User::pluck('name', 'id');
            $data['categories'] = ProductCategory::pluck('name', 'id');
            $data['warehouses'] = Warehouse::pluck('name', 'id');
            $data['payment_methods'] = PaymentMethod::pluck('name', 'id');
            $data['users'] = User::pluck('name', 'id');
            return view('modules.reports.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateSalesByDate(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de ventas por fecha');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['created_by'] = $request->created_by;
            if($request->created_by){
                $data['sales'] = Sale::where('sale_status_id', 2)->where('created_by', $request->created_by)
                    ->with('details')->with('client')
                    ->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                    ->get();
            }else{
                $data['sales'] = Sale::where('sale_status_id', 2)->with('details')->with('client')
                    ->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                    ->get();
            }
            return view('modules.reports.byDateEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateSalesByDatePdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            if($request->created_by){
                $data['sales'] = Sale::where('sale_status_id', 2)->where('created_by', $request->created_by)
                    ->with('details')->with('client')
                    ->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                    ->get();
            }else{
                $data['sales'] = Sale::where('sale_status_id', 2)->with('details')->with('client')
                    ->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                    ->get();
            }
            $pdf = PDF::loadView('modules.reports.templates.byDate', $data)->setPaper('letter', 'landscape');
            return $pdf->download('Reporte - Ventas por fecha - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateSaleByClient(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de ventas por cliente');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['client_id'] = $request->client_id;
            $data['sales'] = Sale::where('sale_status_id', 2)->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client_id);
            })->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')->get();
            $client = Client::findOrFail($request->client_id);
            $data['client'] = $client->name;
            return view('modules.reports.byClientEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateSaleByClientPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['sales'] = Sale::where('sale_status_id', 2)->whereHas('client', function ($q) use ($request) {
                $q->where('id', $request->client_id);
            })->whereBetween('closed_at',[$date_from, $date_to])->orderBy('id', 'DESC')->get();
            $client = Client::findOrFail($request->client_id);
            $data['client'] = $client->name;
            $pdf = PDF::loadView('modules.reports.templates.byClient', $data);
            return $pdf->download('Reporte - Ventas por cliente - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCredit()
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de creditos por cobrar');
            $data['clients'] = Client::whereHas('activeLoans')->orderBy('id', 'DESC')->get();
            $data['loans'] = Loan::orderBy('id', 'DESC')->where('closed', 0)->get();
            return view('modules.reports.byCreditEmbed', $data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCreditPdf()
    {
        try{
            $this->authorize('reports', User::class);
            $data['clients'] = Client::whereHas('activeLoans')->orderBy('id', 'DESC')->get();
            $data['loans'] = Loan::orderBy('id', 'DESC')->where('closed', 0)->get();
            $pdf = PDF::loadView('modules.reports.templates.byCredit', $data);
            return $pdf->download('Reporte - Creditos por - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByProduct(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de creditos por producto');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['product_id'] = $request->product_id;
            $data['product'] = Product::where('id', $request->product_id)->pluck('name')->first();
            $data['details'] = SaleDetail::where('product_id', $request->product_id)
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
               })->get();
            return view('modules.reports.byProductEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByProductPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['product'] = Product::where('id', $request->product_id)->pluck('name')->first();
            $data['details'] = SaleDetail::where('product_id', $request->product_id)
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
               })->get();
            $pdf = PDF::loadView('modules.reports.templates.byProduct', $data);
            return $pdf->download('Reporte - Ventas por producto - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByBs(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte generado en Bs.');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['payments'] = Payment::whereNotNull('amount_bs')
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
               })->get();
            return view('modules.reports.byBsEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByBsPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['payments'] = Payment::whereNotNull('amount_bs')
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
               })->get();
            $pdf = PDF::loadView('modules.reports.templates.byBs', $data);
            return $pdf->download('Reporte - Generado en Bs - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByStock(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte del stock disponible');
            if($request->warehouse_id){
                $data['items'] = DB::table('stock')
                ->join('products', 'products.id', '=', 'stock.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->select('products.name as name', 'product_categories.name as category', 'stock.price as price', 'stock.qty as qty')
                ->where('stock.qty', '>', 0)
                ->where('stock.warehouse_id', $request->warehouse_id)
                ->orderBy('product_categories.name')
                ->orderBy('products.name')
                ->get();
                $warehouse = Warehouse::findOrFail($request->warehouse_id);
                $data['warehouse'] = "almacen: <strong> " . $warehouse->name . "</strong>";
            }else{
                $data['items'] = DB::table('stock')
                ->join('products', 'products.id', '=', 'stock.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->select('products.name as name', 'product_categories.name as category', 'stock.price as price', 'stock.qty as qty')
                ->where('stock.qty', '>', 0)
                ->orderBy('product_categories.name')
                ->orderBy('products.name')
                ->get();
                $data['warehouse'] = 'todos los almacenes';
            }
            $data['warehouse_id'] = $request->warehouse_id;
            return view('modules.reports.byStockEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByStockPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            if($request->warehouse_id){
                $data['items'] = DB::table('stock')
                ->join('products', 'products.id', '=', 'stock.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->select('products.name as name', 'product_categories.name as category', 'stock.price as price', 'stock.qty as qty')
                ->where('stock.qty', '>', 0)
                ->where('stock.warehouse_id', $request->warehouse_id)
                ->orderBy('product_categories.name')
                ->orderBy('products.name')
                ->get();
                $warehouse = Warehouse::findOrFail($request->warehouse_id);
                $data['warehouse'] = $warehouse->name;
            }else{
                $data['items'] = DB::table('stock')
                ->join('products', 'products.id', '=', 'stock.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->select('products.name as name', 'product_categories.name as category', 'stock.price as price', 'stock.qty as qty')
                ->where('stock.qty', '>', 0)
                ->orderBy('product_categories.name')
                ->orderBy('products.name')
                ->get();
                $data['warehouse'] = 'Todos los almacenes';
            }
            $pdf = PDF::loadView('modules.reports.templates.byStock', $data);
            return $pdf->download('Reporte - Stock disponible - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByType(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de flujo de caja');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;

            if(!empty($request->payment_method_id)){
                $data['payments'] = Payment::where('payment_method_id', $request->payment_method_id)->whereBetween('created_at',[$date_from, $date_to])->get();
                $data['method'] = PaymentMethod::findOrFail($request->payment_method_id);
                return view('modules.reports.byTypeSelectedEmbed',$data);
            }
            $data['payments'] = DB::table('payments')
                ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
                ->join('sales', 'payments.sale_id', '=', 'sales.id')
                ->select('payment_methods.name',  DB::raw('SUM(payments.amount) as amount'))
                ->whereBetween('payments.updated_at',[$date_from, $date_to])
                ->where('sales.sale_status_id',2)
                ->groupBy('payments.payment_method_id')
//                ->orderBy('id', 'desc')
                ->get();
            $loans = LoanPayment::whereBetween('created_at',[$date_from, $date_to])
                ->whereNotNull('payment_method_id')->groupBy('payment_method_id')->get();
            foreach ($loans as $loan){
                $loansItem = (object)[
                    'name' => "<span class='text-success'>". $loan->method->name ."</span><small> (abonos de cuentas por cobrar)</small>",
                    'amount' => $this->getTotalByMethodInLoans($loan->payment_method_id, $date_from, $date_to)];
                $data['payments']->push($loansItem);
            }
//            $loansItem = (object)['name' => 'Abonos cuentas por cobrar', 'amount' => $loans];

//            $deposits = Deposit::where('claimed')->whereBetween('updated_at',[$date_from, $date_to])->sum('amount');
//            $depositsItem = (object)['name' => 'Abonos cuentas por pagar', 'amount' => $deposits];
//            $data['payments']->push($depositsItem);
            return view('modules.reports.byTypeEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByTypePdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            if(!empty($request->method)){
                $data['payments'] = Payment::where('payment_method_id', $request->method_id)->whereBetween('created_at',[$date_from, $date_to])->get();
                $data['method'] = $request->method;
                $pdf = PDF::loadView('modules.reports.templates.byTypeSelected', $data);
                return $pdf->download('Reporte - Flujo de caja - '.date('dmY').'.pdf');
            }

            $data['payments'] = DB::table('payments')
                ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
                ->join('sales', 'payments.sale_id', '=', 'sales.id')
                ->select('payment_methods.name',  DB::raw('SUM(payments.amount) as amount'))
                ->whereBetween('payments.updated_at',[$date_from, $date_to])
                ->where('sales.sale_status_id',2)
                ->groupBy('payments.payment_method_id')
//                ->orderBy('id', 'desc')
                ->get();
            $loans = LoanPayment::whereBetween('created_at',[$date_from, $date_to])
                ->whereNotNull('payment_method_id')->groupBy('payment_method_id')->get();
            foreach ($loans as $loan){
                $loansItem = (object)[
                    'name' => "<span class='text-success'>". $loan->method->name ."</span><small> (abonos de cuentas por cobrar)</small>",
                    'amount' => $this->getTotalByMethodInLoans($loan->payment_method_id, $date_from, $date_to)];
                $data['payments']->push($loansItem);
            }
            $pdf = PDF::loadView('modules.reports.templates.byType', $data);
            return $pdf->download('Reporte - Flujo de caja - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByExpense(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de gastos');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['expenses'] = Expense::whereBetween('date',[$date_from, $date_to])
                ->orderBy('id', 'DESC')
                ->get();

            return view('modules.reports.byExpenseEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByExpensePdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['expenses'] = Expense::whereBetween('date',[$date_from, $date_to])
                ->orderBy('id', 'DESC')
                ->get();
            $pdf = PDF::loadView('modules.reports.templates.byExpense', $data);
            return $pdf->download('Reporte - Gastos - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByProfit(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de ganancias');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $payments = DB::table('payments')
                ->join('sales', 'payments.sale_id', '=', 'sales.id')
                ->select(DB::raw('SUM(payments.amount) as amount'))
                ->whereBetween('payments.updated_at',[$date_from, $date_to])
                ->where('sales.sale_status_id',2)
                ->first();
            $details = SaleDetail::select(DB::raw('SUM(price) as price'),
                DB::raw('SUM(cost_price) as cost_price'))
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
                })->first();


            $data['payments'] = $payments->amount;
            $data['earnings'] = $details->price;
            $data['commissions'] = ($data['earnings'] * $this->config['commission_percentage']) / 100;
            $data['expenses'] = Expense::sum('amount');
            $data['cost_price'] = $details->cost_price;
            return view('modules.reports.byProfitEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByProfitPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $payments = DB::table('payments')
                ->join('sales', 'payments.sale_id', '=', 'sales.id')
                ->select(DB::raw('SUM(payments.amount) as amount'))
                ->whereBetween('payments.updated_at',[$date_from, $date_to])
                ->where('sales.sale_status_id',2)
                ->first();
            $details = SaleDetail::select(DB::raw('SUM(price) as price'),
                DB::raw('SUM(cost_price) as cost_price'))
                ->whereBetween('updated_at',[$date_from, $date_to])->orderBy('id', 'DESC')
                ->whereHas('sale', function ($q){
                    $q->where('sale_status_id', 2);
                })->first();

            $data['payments'] = $payments->amount;
            $data['earnings'] = $details->price;
            $data['commissions'] = ($details->price * $this->config['commission_percentage']) / 100;
            $data['expenses'] = Expense::sum('amount');
            $data['cost_price'] = $details->cost_price;
            $pdf = PDF::loadView('modules.reports.templates.byProfit', $data);
            return $pdf->download('Reporte - Ganancias - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCommission(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de comisiones de ventas');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['created_by'] = $request->created_by;
            if($request->created_by){
                $data['users'] = User::where('id', $request->created_by)->with(['sales' => function($q) use ($date_from, $date_to){
                    $q->where('sale_status_id', 2)->whereBetween('closed_at',[$date_from, $date_to]);
                }])->orderBy('name')->get();
            }else{
                $data['users'] = User::with(['sales' => function($q) use ($date_from, $date_to){
                    $q->where('sale_status_id', 2)->whereBetween('closed_at',[$date_from, $date_to]);
                }])->orderBy('name')->get();
            }
            return view('modules.reports.byCommissionEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCommissionPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['created_by'] = $request->created_by;
            if($request->created_by){
                $data['users'] = User::where('id', $request->created_by)->with(['sales' => function($q) use ($date_from, $date_to){
                    $q->where('sale_status_id', 2)->whereBetween('closed_at',[$date_from, $date_to]);
                }])->orderBy('name')->get();
            }else{
                $data['users'] = User::with(['sales' => function($q) use ($date_from, $date_to){
                    $q->where('sale_status_id', 2)->whereBetween('closed_at',[$date_from, $date_to]);
                }])->orderBy('name')->get();
            }
            $pdf = PDF::loadView('modules.reports.templates.byCommission', $data);
            return $pdf->download('Reporte - Comisiones - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCategory(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de ventas por categoría');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['category_id'] = $request->category_id;
            $category = ProductCategory::findOrfail($request->category_id);
            $data['category_name'] = $category->name;
            $data['sales'] = DB::table('sale_details')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                ->select('products.identifier as identifier', 'products.name as name', 'product_categories.name as category',
                    DB::raw('SUM(sale_details.qty) as sold'), DB::raw('SUM(sale_details.price) as money'))
                ->where('products.product_category_id', '=', $data['category_id'])
                ->where('sales.sale_status_id', '=', 2)
                ->whereBetween('sales.closed_at',[$date_from, $date_to])
                ->groupBy('products.id')
                ->orderBy('sold', 'desc')
                ->get();
            return view('modules.reports.byCategoryEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByCategoryPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['category_id'] = $request->category_id;
            $category = ProductCategory::findOrfail($request->category_id);
            $data['category_name'] = $category->name;
            $data['sales'] = DB::table('sale_details')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
                ->select('products.identifier as identifier', 'products.name as name', 'product_categories.name as category',
                    DB::raw('SUM(sale_details.qty) as sold'), DB::raw('SUM(sale_details.price) as money'))
                ->where('products.product_category_id', '=', $data['category_id'])
                ->where('sales.sale_status_id', '=', 2)
                ->whereBetween('sales.closed_at',[$date_from, $date_to])
                ->groupBy('products.id')
                ->orderBy('sold', 'desc')
                ->get();
            $pdf = PDF::loadView('modules.reports.templates.byCategory', $data);
            return $pdf->download('Reporte - Ventas por categoria - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByReturn(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de items devueltos');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['details'] = SaleDetail::where('returned', 1)->whereBetween('updated_at',[$date_from, $date_to])->get();
            return view('modules.reports.byReturnEmbed',$data);

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByReturnPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['details'] = SaleDetail::where('returned', 1)->whereBetween('updated_at',[$date_from, $date_to])->get();
            $pdf = PDF::loadView('modules.reports.templates.byReturn', $data)->setPaper('letter', 'landscape');
            return $pdf->download('Reporte - Devoluciones - '.date('dmY').'.pdf');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    private function getTotalByMethodInLoans($payment_method_id, $date_from, $date_to)
    {
        $total = LoanPayment::whereBetween('created_at', [$date_from, $date_to])
            ->where('payment_method_id', $payment_method_id)->sum('amount');
        return $total;
    }

    public function generateMinStockPdf()
    {
        try{
            $this->authorize('listInventory', User::class);
            $data['items'] = Stock::whereRaw("qty <= min_stock")->get();
            $pdf = PDF::loadView('modules.stock.minStockReportTemplate', $data);
            return $pdf->download('Reporte - Stock minimo - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByStockLog(Request $request){
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de cambios en el inventario');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['created_by'] = $request->created_by;
            $data['product_id'] = $request->product_id;
            $data['logs'] = StockLog::whereBetween('created_at',[$date_from, $date_to])
            ->whereNested(function($query) use($request)
                {
                    if($request->user_id){
                        $query->where('created_by', $request->user_id);
                    }
                    if($request->product_id){
                        $query->where('product_id', $request->product_id);
                    }
                })
            ->orderBy('id', 'DESC')->get();
            return view('modules.reports.byStockLogEmbed',$data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function generateByStockLogPdf(Request $request)
    {
        try{
            $this->authorize('reports', User::class);
            $this->setSeo('Reporte de cambios en el inventario');
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['created_by'] = $request->created_by;
            $data['product_id'] = $request->product_id;
            $data['logs'] = StockLog::whereBetween('created_at',[$date_from, $date_to])
            ->whereNested(function($query) use($request)
                {
                    if($request->user_id){
                        $query->where('created_by', $request->user_id);
                    }
                    if($request->product_id){
                        $query->where('product_id', $request->product_id);
                    }
                })
            ->orderBy('id', 'DESC')->get();
            $pdf = PDF::loadView('modules.reports.templates.byStockLog', $data);
            return $pdf->download('Reporte - Ventas por categoria - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

}
