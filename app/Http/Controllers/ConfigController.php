<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;

class ConfigController extends Controller
{
    use SEO;

    public function index()
    {
        try{
            $this->authorize('config', User::class);
            $data['vars'] = Config::orderBy('id','desc')->get();
            $this->setSeo('Variables de configuración');
            return view('modules.vars.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(ConfigRequest $request){
        try{
            $this->authorize('config', User::class);
            $var = new Config();
            $var->fill($request->all());
            $var->created_by = auth()->user()->id;
            $var->save();
            $request->session()->flash('message', "Variable ".$request->key." creada exitosamente");
            return redirect()->route('config.index');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(ConfigRequest $request){
        try{
            $this->authorize('config', User::class);
            $var = Config::findOrFail($request->var_id);
            $var->fill($request->all());
            $var->save();
            $request->session()->flash('message', "Variable ".$request->key." actualizada exitosamente");
            return redirect()->route('config.index');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('config', User::class);
            $data = Config::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Variable eliminada :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect()->route('config.index');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
