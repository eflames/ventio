<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCreditRequest;
use App\Models\Deposit;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    use SEO;

    public function list()
    {
        try{
            $this->authorize('listCredits', User::class);
            $this->setSeo('Lista de créditos por pagar');
            $data['credits'] = Deposit::orderBy(DB::raw('claimed IS NOT NULL, claimed'), 'desc')
                ->orderBY('id', 'desc')->with('client')->get();
            return view('modules.credits.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function create(AddCreditRequest $request)
    {

        try{
            $this->authorize('manageCredits', User::class);
            $credit = new Deposit();
            $credit->client_id = $request->client_id;
            $credit->amount = $request->amount;
            $credit->comment = $request->comment;
            $credit->created_by = Auth::id();
            $credit->save();
            $request->session()->flash('message', 'Crédito a favor agregado con éxito');
            return redirect('cuentas/por-pagar');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function addAmount(Request $request)
    {
        try{
            $paymentAmount = $request->amount;
            $deposit = Deposit::findOrFail($request->credit_id);
            if($paymentAmount > $deposit->amount){
                return redirect()->route('credits.list')->with('error', 'No puede abonar un monto mayor a la deuda');
            }
            $deposit->amount -= $paymentAmount;
            $deposit->comment = $request->comment;
            if($deposit->amount == 0){
                $deposit->claimed = 1;
            }
            $deposit->save();
            return redirect()->route('credits.list')->with('message', 'Abono registrado exitosamente');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }


    public function destroy($id, Request $request){
        try{
            $this->authorize('manageCredits', User::class);
            $data = Deposit::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Crédito eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('cuentas/por-pagar');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
