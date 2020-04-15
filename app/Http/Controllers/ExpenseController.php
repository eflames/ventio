<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Traits\SEO;
use App\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('listCredits', User::class);
            $data['expenses'] = Expense::orderBy('id','desc')->get();
            $this->setSeo('Gastos');
            return view('modules.expenses.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(ExpenseRequest $request){
        try{
            $this->authorize('manageCredits', User::class);
            $expense = new Expense();
            $expense->fill($request->all());
            $expense->created_by = auth()->id();
            $expense->save();
            $request->session()->flash('message', "Gasto creado exitosamente");
            return redirect()->route('expenses.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(ExpenseRequest $request){
        try{
            $this->authorize('manageCredits', User::class);
            $expense = Expense::findOrFail($request->expense_id);
            $expense->fill($request->all());
            $expense->save();
            $request->session()->flash('message', "Gasto modificado exitosamente");
            return redirect()->route('expenses.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('manageCredits', User::class);
            $data = Expense::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Gasto eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect()->route('expenses.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
