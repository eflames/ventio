<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVRequest;
use App\Http\Requests\StockRequest;
use App\Libraries\CSVStockImporter;
use App\Libraries\StockUtils;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Warehouse;
use App\Traits\SEO;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StockController extends Controller
{
    use SEO;

    public function index(Request $request){
        try{
            $this->authorize('listInventory', User::class);
            $query = $request->searchquery ? : '';
            $almacen = $request->almacen ? : '';
            // dd($slug);
            $data['stock'] = Stock::search(['product.identifier', 'product.name'], $query)
            ->whereNested(function($query) use($almacen)
            {
                if($almacen){
                    $warehouse = Warehouse::where('slug', $almacen)->pluck('id')->first() ?: '';
                    $query->where('warehouse_id', $warehouse);
                }
            })->orderby('id', 'desc')->paginate(30);

            if($query){
                $data['stock']->appends(['searchquery' => $request->searchquery]);
            }
            if($almacen){
                $data['stock']->appends(['almacen' => $almacen]);
            }

            if ($request->ajax()) {
                return view('modules.stock.partials.recordsTable', $data)->render();
            }
            $data['warehouses'] = Warehouse::orderBy('id','desc')->get()->pluck('name', 'id');
            $data['wares'] = Warehouse::orderBy('id','desc')->get();
            $data['almacen'] = $almacen;
            $this->setSeo('Stock');
            return view('modules.stock.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    
    // public function getFilteredStock(Request $request)
    // {
    //     try{
    //         $this->authorize('listInventory', User::class);
    //         $query = $request->searchquery ? : '';
    //         if(empty($query)){
    //             $data['stock'] = Stock::orderBy('id', 'desc')->paginate(30);
    //         }else{
    //             // $data['stock'] = Stock::search(['product.identifier', 'product.name'], $query)->orderby('id', 'desc')->take(100)->get();
    //             $data['stock'] = Stock::search(['product.identifier', 'product.name'], $query)->orderby('id', 'desc')->paginate(30);
    //             $data['stock']->appends(['searchquery' => $request->searchquery]);
    //         }
            
    //         return view('modules.stock.partials.recordsTable', $data)->render();
    //         // return json_encode($sales);
    //     }catch (\Exception $e){
    //         return view('errors.exception')->with('error', $e->getMessage());
    //     }
    // }


    public function showLog(){
        try{
            $this->authorize('manageInventory', User::class);
            $data['logs'] = StockLog::orderBy('id', 'desc')->paginate(20);
            $data['users'] = User::pluck('name', 'id');
            $this->setSeo('Cambios realizados al stock');
            return view('modules.stock.log', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function showLogFiltered(Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $this->setSeo('Cambios realizados al stock');
            $date_from = $request->date_from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_from. ' 00:00:01') : '2019-01-01 00:00:01';
            $date_to = $request->date_to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->date_to. ' 23:59:59') : Carbon::now();
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
            ->orderBy('id', 'DESC')->paginate(20);
            $data['filtered'] = true;
            $data['users'] = User::pluck('name', 'id');
            $data['logs']->appends([
            'user_id' => $request->user_id,
            'created_by' => $request->created_by,
            'product_id' => $request->product_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to
            ]);
            return view('modules.stock.log', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    
    public function listMinStock(){
        try{
            $this->authorize('listInventory', User::class);
            $data['stock'] = Stock::whereRaw("qty <= min_stock")->get();
            $this->setSeo('Stock Mínimo de productos');
            return view('modules.stock.listMinStock', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    // public function filteredList($slug){
    //     try{
    //         $this->authorize('listInventory', User::class);
    //         $warehouse = Warehouse::where('slug', $slug)->first();
    //         $data['warehouses'] = Warehouse::orderBy('id','desc')->get()->pluck('name', 'id');
    //         $data['wares'] = Warehouse::orderBy('id','desc')->get();
    //         $data['stock'] = Stock::orderBy('product_id','desc')->where('warehouse_id', $warehouse->id)->with('product')->get();
    //         $data['filter'] = $warehouse->name;
    //         $data['filterSlug'] = $warehouse->slug;
    //         $this->setSeo('Stock');
    //         return view('modules.stock.listFiltered', $data);
    //     }catch (\Exception $e){
    //         return view('errors.exception')->with('error', $e->getMessage());
    //     }
    // }

    public function store(StockRequest $request){
        try{
            $this->authorize('manageInventory', User::class);
            $check = Stock::where('product_id', $request->product_id)
                ->where('price', $request->price)
                ->where('cost_price', $request->cost_price)
                ->where('warehouse_id', $request->warehouse_id)->first();
            if ($check){
                $stock = $check;
            }else{
                $stock = new Stock();
                $stock->price = $request->price;
                $stock->cost_price = $request->cost_price;
                $stock->warehouse_id = $request->warehouse_id;
                $stock->product_id = $request->product_id;
                $stock->min_stock = $request->min_stock;
            }
            $stock->created_by = Auth::id();
            $stock->qty += $request->qty;
            $stock->save();
            $product = Product::find($request->product_id);
            $warehouse = Warehouse::find($request->warehouse_id);
            StockUtils::log($stock->product_id, 'Agregó a <strong>'. $stock->warehouse->name .' (' . $request->qty.')</strong> unidades');
            $msg = 'Se ha agregado un nuevo stock para <strong>'.$product->name. '</strong> en el almacén <strong>'.$warehouse->name.'</strong>';
            $request->session()->flash('message', $msg);
            return redirect()->route('stock.list'); 
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function editPrice(Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $stock = Stock::find($request->stock_id);
            $stock->price = $request->price;
            $stock->cost_price = $request->cost_price;
            $stock->save();
            $request->session()->flash('message', "Precio de <strong>".$request->name."</strong> actualizado exitosamente");
            return redirect()->route('stock.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function setMinStock(Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $stock = Stock::find($request->stock_id);
            $stock->min_stock = $request->min_stock;
            $stock->save();
            $request->session()->flash('message', "Stock minimo de <strong>".$request->name."</strong> actualizado exitosamente");
            return redirect()->route('stock.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function addQty(Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $stock = Stock::find($request->stock_id);
            $stock->qty += $request->qty;
            $stock->save();
            StockUtils::log($stock->product_id, 'Agregó a <strong>'. $stock->warehouse->name .' (' . $request->qty.')</strong> unidades');
            $request->session()->flash('message', $request->qty." unidades añadidas para <strong>".$request->name."</strong> exitosamente");
            return redirect()->route('stock.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function transfer(Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            if ($request->from_warehouse_id == $request->warehouse_id){
            $request->session()->flash('error', 'No puede transferir stock a un mismo almacén.');
            return redirect()->back();
        }
            $oldStock = Stock::find($request->stock_id);
            $check = Stock::where('product_id', $request->product_id)
                ->where('price', $oldStock->price)
                ->where('cost_price', $oldStock->cost_price)
                ->where('warehouse_id', $request->warehouse_id)->first();
            if ($check){
                $stock = $check;
            }else{
                $stock = new Stock();
                $stock->price = $oldStock->price;
                $stock->cost_price = $oldStock->cost_price;
                $stock->warehouse_id = $request->warehouse_id;
                $stock->product_id = $request->product_id;
                $stock->created_by = Auth::id();
            }
            $stock->qty += $request->qty;
            $oldStock->qty -= $request->qty;
            $oldStock->save();
            $stock->save();
            $warehouse = Warehouse::find($request->warehouse_id);
            $msg = '<strong>'.$request->qty.'</strong> unidades transferidas de: <strong>'.strtoupper($request->name).'</strong> desde <strong> '.$request->warehousename.' </strong>hacia<strong> '.strtoupper($warehouse->name).'</strong>';
            $request->session()->flash('message', $msg);
            return redirect()->route('stock.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }


    public function importCSV(CSVRequest $request, CSVStockImporter $importer){
        try{
            $this->authorize('manageInventory', User::class);
            $file = $request->csvfile;
            $proc = $importer->importProducts($file);

            if(!$proc){
                $msg = 'Ocurrió un problema con el archivo, chequea que mantenga el formato y/o no contenga carácteres especiales';
                return redirect('stock')->with('error', $msg);
            }

            $result = $importer->result();
            $request->session()->flash('message', "Archivo importado - <a data-toggle='modal' data-target='#logModal'><strong>VER LOG</strong></a>");
            $request->session()->flash('results', $result);
            return redirect()->route('stock.list');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $data = Stock::findOrFail($id);
            StockUtils::log($data->product_id, 'Eliminó el item del almacén: <strong>'.$data->warehouse->name.' (quedaban: '.$data->qty.')</strong> unidades');
            if($data->delete()) {
                $request->session()->flash('message','Stock eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los 
                administradores del sistema.');
            }
            return redirect()->route('stock.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function downloadStock(){
        try{
            $this->authorize('listInventory', User::class);
            $data['details'] = Stock::with('product')->get()->sortBy('product.name');
            $pdf = PDF::loadView('modules.stock.stockReport', $data)->setPaper('letter');
            return $pdf->download('Reporte - stock - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function downloadFilteredStock($slug){
        try{
            $this->authorize('listInventory', User::class);
            $warehouseId = Warehouse::where('slug', $slug)->pluck('id')->first();
            $data['details'] = Stock::where('warehouse_id', $warehouseId)->with('product')->get()->sortBy('product.name');
            $pdf = PDF::loadView('modules.stock.stockReport', $data)->setPaper('letter');
            return $pdf->download('Reporte - stock - '.date('dmY').'.pdf');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

}
