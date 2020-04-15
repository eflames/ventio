<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVRequest;
use App\Http\Requests\ProductRequest;
use App\Libraries\CSVProductsImporter;
use App\Libraries\StockUtils;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Warehouse;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('listInventory', User::class);
//            $data['products'] = Product::orderBy('id','desc')->with('category')->get();
            $this->setSeo('Productos');
            return view('modules.products.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function getProducts()
    {
        try{
            $this->authorize('sales', User::class);
            $products = DB::table('products')
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                ->select('products.id as id', 'products.description as description', 'products.identifier as identifier', 'products.name as name', 'product_categories.name as category_name')
                ->orderBy('products.id', 'desc')
                ->get();



            return DataTables::of($products)
//                ->setRowAttr(['align' => 'center'])
                ->addColumn('actions', 'modules.products.partials.actionButton')
                ->editColumn('name', function($products) {return '<strong>' . strtoupper($products->name) .'</strong>' ;})
                ->rawColumns(['actions', 'name'])
                ->make(true);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $this->authorize('manageInventory', User::class);
            $data['categories'] = ProductCategory::orderBy('id', 'asc')->pluck('name', 'id');
            $this->setSeo('Productos - nuevo producto');
            return view('modules.products.create', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(ProductRequest $request){
        try{
            $this->authorize('manageInventory', User::class);
            $product = new Product();
            $product->fill($request->all());
            $product->created_by = Auth::user()->id;
            $product->save();
            $request->session()->flash('message', "Producto ".$request->name." creado exitosamente");
            return redirect('productos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $this->authorize('manageInventory', User::class);
            $data['product'] = Product::findOrfail($id);
            $data['categories'] = ProductCategory::orderBy('id', 'asc')->pluck('name', 'id');
            $this->setSeo('Productos - editar producto');
            return view('modules.products.edit', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }


    public function update(ProductRequest $request){
        try{
            $this->authorize('manageInventory', User::class);
            $product = Product::findOrFail($request->id);
            $product->fill($request->all());
            $product->save();
            $request->session()->flash('message', "Producto ".$request->name." editado exitosamente");
            return redirect('productos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('manageInventory', User::class);
            $data = Product::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Producto eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los 
                administradores del sistema.');
            }
            return redirect('productos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function importCSV(CSVRequest $request, CSVProductsImporter $importer){
        try{
            $this->authorize('manageInventory', User::class);
            $file = $request->csvfile;
            $proc = $importer->importProducts($file);

            if(!$proc){
                $msg = 'Ocurrió un problema con el archivo, chequea que mantenga el formato y/o no contenga carácteres especiales';
                return redirect('productos')->with('error', $msg);
            }

            $result = $importer->result();
            $request->session()->flash('message', "Archivo importado - <a data-toggle='modal' data-target='#logModal'><strong>VER LOG</strong></a>");
            $request->session()->flash('results', $result);
            return redirect('productos');

        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function APIgetall(Request $request){
        $this->authorize('listInventory', User::class);
        $query = $request->q ? : '';
        $data = Product::search(['name', 'identifier'], $query)->get();
        $results = [];
        foreach ($data as $result){
            $desription = $result->description ? : 'No se ha agregado descripción aún';
            $results[] = [
                'id' => $result->id,
                'identifier' => $result->identifier,
                'name' => $result->name,
                'category' => $result->category->name,
                'description' => $desription,
                ];
        }
        return response()->json($results);
    }
    public function APIgetallForSale(Request $request){
        $this->authorize('listInventory', User::class);
        $query = $request->q ? : '';
        $data = Product::search(['name', 'identifier'], $query)->whereHas('stock')->get();
        $results = [];
        foreach ($data as $result){
            $stocks = Stock::where('product_id', $result->id)->where('qty', '>', 0)->get();
            foreach ($stocks as $stock){
                $results[] = [
                    'id' => $stock->id,
                    'name' => $stock->product->name,
                    'stock' => $stock->qty,
                    'warehouse' => $stock->warehouse->name,
                    'price' => $stock->price,
//                    'stock' => StockUtils::defaultStock($result->id),
                ];
            }
        }
        return response()->json($results);
    }

}
