<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Mail\NotifyUser;
use App\Models\Client;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Sale;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    use SEO;

    public function index(){
        try{
            $this->authorize('listClients', User::class);
            $data['clients'] = Client::orderBy('id','desc')->get();
            $this->setSeo('Clientes');
            return view('modules.clients.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }


    public function create(){
        try{
            $this->authorize('manageClients', User::class);
            $data['clients'] = Client::orderBy('id', 'desc');
            $this->setSeo('Clientes - nuevo cliente');
            return view('modules.clients.create', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function store(ClientRequest $request){
        try{
            $this->authorize('manageClients', User::class);
            $client = new Client();
            $client->fill($request->all());
            $client->created_by = Auth::user()->id;
            $client->save();
            $request->session()->flash('message', "Cliente ".$request->name." creado exitosamente");
            return redirect('clientes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function fastStore(ClientRequest $request){
        try{
            $this->authorize('manageClients', User::class);
            $client = new Client();
            $client->fill($request->all());
            $client->created_by = Auth::user()->id;
            $client->save();
            if($request->action == 'createandsale'){
                $sale = new Sale();
                $sale->client_id = $client->id;
                $sale->created_by = Auth::user()->id;
                $sale->sale_status_id = 1;
                $sale->save();
                return redirect('venta/'.base64_encode($sale->id).'/edit');
            }else{
                $request->session()->flash('message', "Cliente ".$request->name." creado exitosamente");
                return redirect('/');
            }
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function update(ClientRequest $request){
        try{
            $this->authorize('manageClients', User::class);
            $client = Client::findOrFail($request->id);
            $client->fill($request->all());
            $client->save();
            $request->session()->flash('message', "Cliente ".$request->name." actualizado exitosamente");
            return redirect('clientes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $this->authorize('manageClients', User::class);
            $data['client'] = Client::findOrfail($id);
            $this->setSeo('Clientes - editar producto');
            return view('modules.clients.edit', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, Request $request){
        try{
            $this->authorize('manageClients', User::class);
            $data = Client::findOrFail($id);
            if($data->delete()) {
                $request->session()->flash('message','Cliente eliminado :\'(');
            }else{
                $request->session()->flash('error','Ha ocurrido un error inesperado, por favor contacte a los administradores del sistema.');
            }
            return redirect('clientes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function APIgetall(Request $request){
        $this->authorize('listClients', User::class);
        $query = $request->q ? : '';
        $data = Client::search(['name', 'id_number', 'telephone'], $query)->get();
        $results = [];
        foreach ($data as $result){
            $results[] = [
                'id' => $result->id,
                'name' => $result->name,
                'id_number' => $result->id_number,
                'telephone' => $result->telephone,
//                'buy_times' => $result->compras->count()
            ];
        }
        return response()->json($results);
    }

    public function details($id_number){
        try{
            $this->authorize('listClients', User::class);
            $this->setSeo('Cliente - detalles');
            $data['client'] = Client::where('id_number', $id_number)->first();
            $data['sales'] = Sale::where('client_id', $data['client']->id)->where('sale_status_id', 2)
                ->with('status')->with('details')->orderBy('id', 'DESC')->get();
            $data['credits'] = Loan::where('client_id', $data['client']->id)->orderBy('closed')->orderBy('id','desc')->with('payments')->get();
            $data['deposits'] = Deposit::where('client_id', $data['client']->id)->where('claimed', null)->orderBy('id', 'desc')->get();

            return view('modules.clients.view', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function notifyClient($client_id, Request $request){
        try{
            $this->authorize('manageClients', User::class);
            $client = Client::findOrFail($client_id);
            $data['name'] = $client->name;
            $data['email'] = $client->email;
            $data['amount'] = $client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($client->id);
            $data['store_email'] = $this->config['store_email'];
            $data['store_name'] = $this->config['store_name'];
            Mail::send(new NotifyUser($data));
            $request->session()->flash('message','Notificación enviada al email <strong>'.$client->email.'</strong>');
            return redirect('clientes');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
