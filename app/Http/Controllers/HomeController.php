<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Libraries\ChartUtils;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Sale;
use App\Traits\SEO;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use SEO;

    /**
     * Show the application dashboard.
     *
     * @param ChartUtils $chartUtils
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(ChartUtils $chartUtils)
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
            $data['loansTotal'] = Loan::where('closed', 0)->sum('amount');
            $data['depositsTotal'] = Deposit::where('claimed')->sum('amount');
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
            return redirect('/');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
