<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddLoanPaymentRequest;
use App\Http\Requests\AddSimpleLoanPaymentRequest;
use App\Libraries\LoanUtils;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\PaymentMethod;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class LoanController extends Controller
{
    use SEO;

    public function list()
    {
        try{
            $this->authorize('listCredits', User::class);
            $this->setSeo('Lista de créditos por cobrar');
            $data['credits'] = Loan::orderBy('closed')->orderBy('id','desc')->with('client')->with('payments')->get();
            $data['paymentMethods'] = PaymentMethod::where('id','>',2)->where('id','<>',5)->pluck('name', 'id');
            return view('modules.loans.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function addAmount(AddSimpleLoanPaymentRequest $request)
    {
        try{
            $this->authorize('manageCredits', User::class);
            $loan = Loan::findOrFail($request->credit_id);
            $promiseAmount = $loan->payments->sum('amount') + $request->amount;
            if($promiseAmount > $loan->amount){
                $request->session()->flash('error', 'El monto ingresado supera la cantidad de la deuda');
                return redirect('cuentas/por-cobrar');
            }
            $payment = new LoanPayment();
            $payment->loan_id = $request->credit_id;
            $payment->amount = $request->amount;
            $payment->payment_method_id = $request->payment_method_id;
            $payment->created_by = Auth::id();
            if($promiseAmount == $loan->amount){
                $loan->closed = 1;
                $loan->save();
            }
            $payment->save();
            $request->session()->flash('message', 'Cantidad abonada al crédito correctamente');
            return redirect('cuentas/por-cobrar');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
    public function create(Request $request)
    {
        try{
            $this->authorize('manageCredits', User::class);
            $loan = new Loan();
            $loan->fill($request->all());
            $loan->sale_id = 0;
            $loan->created_by = Auth::id();
            $loan->comment = 'Agregado manualmente por: ' . Auth::user()->name;
            $loan->save();
            $request->session()->flash('message', 'Cuenta por cobrar creada exitosamente sin venta relacionada');
            return redirect('cuentas/por-cobrar');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function closeLoan($id, Request $request)
    {
        try{
            $this->authorize('manageCredits', User::class);
            $loan = Loan::findOrFail($id);
            $amountLeft = $loan->amount - $loan->payments->sum('amount');
            if($amountLeft == 0){
                $request->session()->flash('error', 'Se ha abonado la totalidad de esta deuda, no puede abonar más.');
                return redirect('cuentas/por-cobrar');
            }
            $payment = new LoanPayment();
            $payment->loan_id = $loan->id;
            $payment->amount = $amountLeft;
            $payment->created_by = Auth::id();
            $payment->save();
            $loan->closed = 1;
            $loan->save();
            $request->session()->flash('message', 'Cantidad abonada al crédito correctamente y ha sido marcado como completado.');
            return redirect('cuentas/por-cobrar');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $this->authorize('manageCredits', User::class);
            $data = Loan::findOrFail($id);
            $data->payments()->delete();
            if ($data->delete()) {
                $request->session()->flash('message', 'Crédito eliminado :\'(');
            } else {
                $request->session()->flash('error', 'Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('cuentas/por-cobrar');
        } catch (\Exception $e) {
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

        public function deletePayment($id, Request $request){
            try{
                $this->authorize('manageCredits', User::class);
                $payment = LoanPayment::findOrFail($id);
                $payment->delete();
                $loan = Loan::findOrFail($payment->loan->id);
                $loan->closed = 0;
                $loan->save();
                $request->session()->flash('message','Abono de crédito eliminado :\'(');
                return redirect()->back();
            }catch (\Exception $e){
                return view('errors.exception')->with('error', $e->getMessage());
            }
        }

        public function getPayments($id){
            try{
                $this->authorize('listCredits', User::class);
                $this->setSeo('Registro de pagos');
                $data['loan'] = Loan::findOrFail($id);
                return view('modules.loans.logModal', $data);
            }catch (\Exception $e){
                return view('errors.exception')->with('error', $e->getMessage());
            }
        }

    public function addPayment(AddLoanPaymentRequest $request)
    {
        try{
            $client = Client::findOrFail($request->client_id);
            $total = $client->activeLoans->sum('amount') - LoanUtils::getPayments($request->client_id);
            $paymentAmount = $request->amount;
            $loans = Loan::where('client_id', $request->client_id)->where('closed', 0)->get();
            if($paymentAmount > $total){
                return redirect()->route('loans.list')
                    ->with('error', 'El monto abonado es mayor al total de las deudas de este cliente');
            }
            if(count($loans) > 0){
                foreach($loans as $loan){
                    $loanLeft = $loan->amount - $loan->payments->sum('amount');
                    if($paymentAmount >= $loanLeft){
                        $amountToAdd = $loanLeft;
                        $paymentAmount -= $loanLeft;
                        $loan->closed = 1;
                        $loan->save();
                    }else{
                        $amountToAdd = $paymentAmount;
                        $paymentAmount = 0;
                    }
                    $loanPayment = new LoanPayment;
                    $loanPayment->loan_id = $loan->id;
                    $loanPayment->amount = $amountToAdd;
                    $loanPayment->payment_method_id = $request->payment_method_id;
                    $loanPayment->save();
                    if($paymentAmount == 0){ break;}
                }
            }else{
                return redirect()->route('loans.list')
                    ->with('error', 'Este cliente no tiene deudas para abonar pagos');
            }
            return redirect()->route('loans.list')->with('message', 'Abono registrado exitosamente');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function getClientLoans($client_id)
    {
        try{
            $client = Client::findOrFail($client_id);
            $total = $client->activeLoans->sum('amount') - LoanUtils::getPayments($client_id);
            if ($total>0){
                $message = 'Este cliente tiene una deuda (acumulada) sin pagar de: <strong class="text-danger">$' . number_format($total, 2).'</strong>';
            }else{
                $message = 'Este cliente no posee deudas';
            }
            return response()->json($message);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }
}
