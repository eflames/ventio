<?php

namespace App\Http\Controllers;
use App\Http\Requests\PaymentMethodsRequest;
use App\Models\PaymentMethod;
use App\Traits\SEO;
use App\User;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('config', User::class);
            $data['methods'] = PaymentMethod::orderBy('id','desc')->get();
            $this->setSeo('Métodos de pago');
            return view('modules.paymentMethods.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(PaymentMethodsRequest $request){
        try{
            $this->authorize('config', User::class);
            $method = new PaymentMethod();
            $method->fill($request->all());
            $method->created_by = auth()->user()->id;
            $method->save();
            $request->session()->flash('message', "Método de pago ".$request->name." creado exitosamente");
            return redirect('metodos-de-pago');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('config', User::class);
            $data = PaymentMethod::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Método de pago eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('metodos-de-pago');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(PaymentMethodsRequest $request){
        try{
            $this->authorize('config', User::class);
            $method = PaymentMethod::findOrNew($request->payment_method_id);
            $method->fill($request->all());
            $method->save();
            $request->session()->flash('message', "Método de pago ".$request->name." actualizado exitosamente");
            return redirect('metodos-de-pago');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
