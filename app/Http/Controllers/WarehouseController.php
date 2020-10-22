<?php

namespace App\Http\Controllers;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use App\Traits\SEO;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('config', User::class);
            $data['warehouses'] = Warehouse::orderBy('id','desc')->get();
            $this->setSeo('Almacenes');
            return view('modules.warehouses.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(WarehouseRequest $request){
        try{
            $this->authorize('config', User::class);
            $ware = new Warehouse();
            $ware->fill($request->all());
            $ware->created_by = auth()->user()->id;
            $ware->slug = Str::slug($request->name);
            if($request->is_default == 1){
                //  Warehouse::where('is_default', 1)->update(['is_default' => null]);
                 $ware->is_default = 1;
            }
            $ware->save();
            $request->session()->flash('message', "Almacén ".$request->name." creado exitosamente");
            return redirect('almacenes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(WarehouseRequest $request){
        try{
            $this->authorize('config', User::class);
            $ware = Warehouse::findOrFail($request->warehouse_id);
            $ware->fill($request->all());
            $ware->slug = Str::slug($request->name);
            if($request->is_default == 1){
                Warehouse::where('is_default', 1)->update(['is_default' => null]);
                $ware->is_default = 1;
            }
            $ware->save();
            $request->session()->flash('message', "Almacén ".$request->name." creado exitosamente");
            return redirect('almacenes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('config', User::class);
            $data = Warehouse::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Almacén eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('almacenes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function changeDefault($id, $option, Request $request){
        try{
            $this->authorize('config', User::class);
            $data = Warehouse::findOrFail($id);
            $optVal = $option == 0 ? null : 1;
            // if($optVal == 1){
            //     Warehouse::where('is_default', 1)->update(['is_default' => null]);
            // }
            // $data->is_default = $optVal;
            $data->is_default = $optVal;
            $data->save();
            $request->session()->flash('message', "Almacén ".$data->name." actualizado exitosamente");
            return redirect('almacenes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

}
