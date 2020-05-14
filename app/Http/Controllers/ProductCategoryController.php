<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('config', User::class);
            $data['categories'] = ProductCategory::orderBy('id','desc')->with('products')->get();
            $this->setSeo('Categorías');
            return view('modules.categories.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(ProductCategoryRequest $request){
        try{
            $this->authorize('config', User::class);
            $cat = new ProductCategory();
            $cat->fill($request->all());
            $cat->created_by = auth()->user()->id;
            $cat->slug = Str::slug($request->name);
            $cat->save();
            $request->session()->flash('message', "Categoria ".$request->name." creada exitosamente");
            return redirect('categorias');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(ProductCategoryRequest $request){
        try{
            $this->authorize('config', User::class);
            $cat = ProductCategory::findOrNew($request->category_id);
            $cat->fill($request->all());
            $cat->slug = Str::slug($request->name);
            $cat->save();
            $request->session()->flash('message', "Categoria ".$request->name." actualizada exitosamente");
            return redirect('categorias');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('config', User::class);
            $data = ProductCategory::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Categoría eliminada :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('categorias');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
