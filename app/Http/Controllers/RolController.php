<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolRequest;
use App\Models\Rol;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('users', User::class);
            $this->setSeo('Permisos');
            $data['roles'] = Rol::all();
            return view('modules.roles.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $this->authorize('users', User::class);
            $this->setSeo('Permisos');
            return view('modules.roles.create');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(RolRequest $request){
        try{
            $this->authorize('users', User::class);
            $rol = new Rol();
            $rol->fill($request->all());
            $rol->created_by = Auth::user()->id;
            $rol->save();
            $request->session()->flash('message', "Rol de permisos ".$request->name." creado exitosamente");
            return redirect('usuarios/permisos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(RolRequest $request){
        try{
            $this->authorize('users', User::class);
            $rol = Rol::findOrFail($request->id);
            $rol->name = $request->name;
            $rol->p_sell = $request->p_sell;
            $rol->p_sales = $request->p_sales;
            $rol->p_s_inventory = $request->p_s_inventory;
            $rol->p_e_inventory = $request->p_e_inventory;
            $rol->p_s_clients = $request->p_s_clients;
            $rol->p_e_clients = $request->p_e_clients;
            $rol->p_s_credits = $request->p_s_credits;
            $rol->p_e_credits = $request->p_e_credits;
            $rol->p_discount = $request->p_discount;
            $rol->p_reports = $request->p_reports;
            $rol->p_users = $request->p_users;
            $rol->p_config = $request->p_config;
            $rol->save();
            $request->session()->flash('message', "Rol de permisos ".$request->name." actualizado exitosamente");
            return redirect('usuarios/permisos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $this->authorize('users', User::class);
            $this->setSeo('Editar permiso');
            $data['rol'] = Rol::findOrFail($id);
            return view('modules.roles.edit', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('users', User::class);
            $data = Rol::findOrFail($id);
            if($data->users->count() > 0){
                $request->session()->flash('error','No se puede eliminar un rol de permiso de usuario si este posee usuarios asociados.');
                return redirect('usuarios/permisos');
            }
            if($data->delete()) {
                $request->session()->flash('message','Permiso eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('usuarios/permisos');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
