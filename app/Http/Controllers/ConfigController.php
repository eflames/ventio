<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Http\Requests\SetLogoRequest;
use App\Models\Config;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use App\Libraries\ImageUtil;
use App\Models\Loan;
use App\Models\Deposit;


class ConfigController extends Controller
{
    use SEO;

    public function index()
    {
        try{
            $this->authorize('config', User::class);
            $data['vars'] = Config::orderBy('id','desc')->get();
            $this->setSeo('Configuración avanzada');
            return view('modules.vars.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function general()
    {
        try{
            $this->authorize('config', User::class);
            $data['vars'] = Config::orderBy('id','desc')->get();
            $this->setSeo('Configuración general');
            return view('modules.vars.general', $data);
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

    public function maintenance(Request $request){
        try{
            $this->authorize('config', User::class);
            $loans = Loan::where('closed', 1)->get();
            foreach ($loans as $loan) {
                $loan->payments()->delete();
                $loan->delete();
            }
            Deposit::where('amount', 0)->delete();
            $request->session()->flash('message','Mantenimiento realizado con éxito');
            return redirect()->route('config.general');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    
    public function setVar(Request $request){
        try{
            $this->authorize('config', User::class);
            $config = Config::where('key', $request->option)->first();
            $config->value = $request->value;
            $config->save();
            $request->session()->flash('message','Configuraciones actualizadas');
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    
    public function setStore(Request $request){
        try{
            $this->authorize('config', User::class);
            $name = Config::where('key', 'store_name')->first();
            $name->value = $request->store_name;
            $name->save();
            $email = Config::where('key', 'store_email')->first();
            $email->value = $request->store_email;
            $email->save();

            $request->session()->flash('message','Configuraciones actualizadas');
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    
    public function setImage(SetLogoRequest $request){
        try{
            $this->authorize('config', User::class);
            $image = new ImageUtil();
            $image->procImage($request->image);
            $request->session()->flash('message','Logo de la aplicación actualizado');
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

}
