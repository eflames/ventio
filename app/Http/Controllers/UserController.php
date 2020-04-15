<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Models\Rol;
use App\Traits\SEO;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('users', User::class);
            $data['users'] = User::orderBy('id','desc')->get();
            $this->setSeo('Usuarios');
            return view('modules.users.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $this->authorize('users', User::class);
            $data['userRoles'] = Rol::orderBy('id', 'asc')->pluck('name','id');
            $this->setSeo('Usuarios - nuevo usuario');
            return view('modules.users.create', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(UserRequest $request){
        try{
            $this->authorize('users', User::class);
            $user = new User();
            $user->fill($request->all());
            $user->created_by = Auth::user()->id;
            $user->password = bcrypt($request->password);
            $user->save();
            $request->session()->flash('message', "Usuario ".$request->name." creado exitosamente");
            return redirect('usuarios');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $this->authorize('users', User::class);
            $data['user'] = User::findOrfail($id);
            $data['userRoles'] = Rol::orderBy('id', 'asc')->pluck('name','id');
            return view('modules.users.edit', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(UserEditRequest $request){
        try{
            $this->authorize('users', User::class);
            $user = User::findOrFail($request->id);
            $user->fill($request->all());
            if(!empty($request->password)){
                $user->password = bcrypt($request->password);
            }
            $user->save();
            $request->session()->flash('message', "Usuario ".$request->name." actualizado exitosamente");
            return redirect('usuarios');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('users', User::class);
            $data = User::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Usuario eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('usuarios');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
