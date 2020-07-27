<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Libraries\ChartUtils;
use App\Libraries\LicenseUtils;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Sale;
use App\Traits\SEO;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;

class HomeController extends Controller
{
    use SEO;

    /**
     * Show the application dashboard.
     *
     * @param ChartUtils $chartUtils
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(ChartUtils $chartUtils, Request $request)
    {
        try{
            $this->setSeo('Inicio');
            $data['salesToday'] = Sale::whereDate('updated_at', Carbon::today())->where('sale_status_id', 2)
                ->with('details')->get();
            $quantity = 0;
            Sale::whereDate('updated_at', Carbon::today())->where('sale_status_id', 2)
                ->each(function($p) use (&$quantity) {
                    $quantity += $p->details->sum('qty');
                });
            $data['soldItems'] = $quantity;
            $data['sales'] = Sale::orderBy('id', 'desc')->where('sale_status_id', 2)->take(7)
                ->with('details')->with('client')->get();
            $loansTotal = Loan::where('closed', 0)->sum('amount');
            $loansPaymentsTotal = LoanPayment::whereHas('loan', function($q){
                $q->where('closed', 0);
            })->sum('amount');
            $data['loansTotal'] = $loansTotal - $loansPaymentsTotal;
            $data['depositsTotal'] = Deposit::where('claimed')->sum('amount');
            $minStock_alert = Stock::whereRaw("qty <= min_stock")->get();
            if($minStock_alert->count() > 0){
                $request->session()->flash('warning', 'Uno o más productos estan por debajo del stock mínimo.');
            }
            if(LicenseUtils::warning()){
                $request->session()->flash('info', 'La licencia está por vencer. Adquiera una nueva licencia y actualice en la seccion de configuración.');
            }
            $data += $chartUtils->getChartData();
            return view('modules.home.dashboard', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function profile()
    {
        try{
            $data['user'] = User::findOrfail(Auth::id());
            return view('modules.home.profile', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function changeuser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->back();
        }else{
            $msg = 'Ha ocurrido un problema intentando cambiar de usuario. Revise los datos ingresados e intente nuevamente';
            return redirect()->route('home')->with('error', $msg);
        }
    }

    public function storeProfile(ProfileRequest $request)
    {
        try{
            $user = User::findOrFail(Auth::id());
            $user->fill($request->all());
            if(!empty($request->password)){
                $user->password = bcrypt($request->password);
            }
            $user->save();
            $request->session()->flash('message', 'Perfil actualizado exitosamente');
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function about()
    {
        try{
            $this->setSeo('Acerca de Ventio');
            return view('modules.home.about');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
