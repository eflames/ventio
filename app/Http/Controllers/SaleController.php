<?php

namespace App\Http\Controllers;

use App\Libraries\StockUtils;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Rol;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Warehouse;

class SaleController extends Controller
{

    use SEO;

    public function newSale(Request $request)
    {
        try{
            $user = Auth::user();
            $this->authorize('sell', $user);
            $checkOpenSale = Sale::where('client_id', $request->client_id)->where('sale_status_id', 1)->first();
            if($checkOpenSale){
                return back()->with('error', 'Este cliente ya posee una venta abierta (#'. $checkOpenSale->id .'),
                continúe la venta mencionada o elimine para crear una nueva.');
            }
            $sale = new Sale();
            $sale->client_id = $request->client_id;
            $sale->created_by = $user->id;
            $sale->sale_status_id = 1;
            $sale->save();
            return redirect('venta/'.base64_encode($sale->id).'/edit');
        } catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }

    }

    public function sale($idc)
    {
        try{
            $this->authorize('sell', User::class);
            $id = base64_decode($idc);
            $data['sale'] = Sale::findOrFail($id);
            if ($data['sale']->sale_status_id == 2){
                return redirect('venta/'.base64_encode($data['sale']->id));
            }
            $data['details'] = SaleDetail::where('sale_id', $id)->get();
            $data['saleTotal'] = $data['details']->sum('price');
            $data['paymentMethods'] = PaymentMethod::where('id','<>',1)->where('id','<>',5)->pluck('name', 'id');
            $data['saleTotal'] == 0 ? $saleTotal = 1 : $saleTotal = $data['saleTotal'];
            $data['paymentPercentage'] = round( ($data['sale']->payments->sum('amount') * 100) / $saleTotal, 1, PHP_ROUND_HALF_DOWN);
            $data['balance'] = $data['sale']->client->balance->sum('amount');
            $data['sellers'] = User::where('id', '<>', Auth::id())->pluck('name', 'id');
            $data['warehouses'] = Warehouse::orderBy('id','desc')->get();
            $data['default_warehouse'] = Warehouse::where('is_default', 1)->first();
            $this->setSeo('Nueva venta');
            return view('modules.sales.create', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function addItemToSale(Request $request)
    {
        try{
            $this->authorize('sell', User::class);
            $stock = Stock::findOrFail($request->stock_id);
            $product_id = $stock->product_id;
            if ($request->qty > $stock->qty){
                return response()->json('La cantidad es mayor a la disponible.',401);
            }
            $checkExist = SaleDetail::where('stock_id', $request->stock_id)->where('sale_id', $request->sale_id)->first();
            if($checkExist){
                $dobleCheck = $checkExist->qty + $request->qty;
                if ($dobleCheck > $stock->qty){
                    return response()->json('La cantidad es mayor a la disponible.',401);
                }
                $saleDetail = $checkExist;
                $saleDetail->qty += $request->qty;
            }else{
                $saleDetail = new SaleDetail();
                $saleDetail->sale_id = $request->sale_id;
                $saleDetail->product_id = $product_id;
                $saleDetail->qty = $request->qty;
                $saleDetail->stock_id = $request->stock_id;
            }
            $saleDetail->price = $stock->price * $saleDetail->qty;
            $saleDetail->cost_price = $stock->cost_price * $saleDetail->qty;
            $saleDetail->created_by = Auth::id();
            $saleDetail->save();
            return response()->json($saleDetail->product->name . ' agregado a esta venta');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function getSaleItems($id)
    {
        try{
            $this->authorize('sell', User::class);
            $data['details'] = SaleDetail::where('sale_id', $id)->get();
            return view('modules.sales.partials.itemList', $data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function getButtons($saleId)
    {
        try{
            $data['sale'] = Sale::findOrFail($saleId);
            $data['saleTotal'] = SaleDetail::where('sale_id', $saleId)->sum('price');
            return view('modules.sales.partials.procButtons', $data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function getBalance($saleId)
    {
        try{
            $data['sale'] = Sale::findOrFail($saleId);
            $data['balance'] = $data['sale']->client->balance->sum('amount');
            $data['saleTotal'] = SaleDetail::where('sale_id', $saleId)->sum('price');
            return view('modules.sales.partials.creditAvailable', $data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function deleteSale($id)
    {
        try{
            $this->authorize('sell', User::class);
            Deposit::where('claimed_in_sale_id', $id)
                ->update(['claimed' => NULL, 'claimed_in_sale_id' => NULL]);
            $loan = Loan::where('sale_id', $id)->first();
            if ($loan){
                LoanPayment::where('loan_id', $loan->id)->delete();
                $loan->delete();
            }
            SaleDetail::where('sale_id', $id)->delete();
            Payment::where('sale_id', $id)->delete();
            Sale::destroy($id);
            return redirect('/ventas')->with('message', 'Venta eliminada :(');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function applyBalance($saleId)
    {
        try{
            $this->authorize('sell', User::class);
            $sale = Sale::findOrFail($saleId);
            $balance = $sale->client->balance->sum('amount');
            $payment = new Payment();
            $payment->created_by = 1;
            $payment->sale_id = $saleId;
            $payment->client_id = $sale->client->id;
            $payment->payment_method_id = 1;
            $payment->comment = 'Crédito pendiente usado en esta venta';
            $payment->amount = $balance;
            $payment->save();
            Deposit::where('client_id', $sale->client->id)
                ->where('claimed')->update(['claimed' => 1, 'claimed_in_sale_id' => $saleId]);
            return response()->json('Deposit aplicado para esta venta');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function getPayments($id)
    {
        try{
            $data['sale'] = Sale::findOrFail($id);
            $data['details'] = SaleDetail::where('sale_id', $id)->get();
            $data['saleTotal'] = SaleDetail::where('sale_id', $id)->sum('price');
            $data['saleTotal'] == 0 ? $saleTotal = 1 : $saleTotal = $data['saleTotal'];
            $data['paymentMethods'] = PaymentMethod::where('id','<>',1)->where('id','<>',5)->pluck('name', 'id');
            $data['paymentPercentage'] = round( ($data['sale']->payments->sum('amount') * 100) / $saleTotal, 1, PHP_ROUND_HALF_DOWN);
            return view('modules.sales.partials.salePayments', $data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }
    public function getSaleTotal($id)
    {
        try{
            $data['saleTotal'] = SaleDetail::where('sale_id', $id)->sum('price');
            return view('modules.sales.partials.saleTotal', $data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function deleteItem($id)
    {
        try{
            $this->authorize('sell', User::class);
            SaleDetail::destroy($id);
            return response()->json('Item eliminado de esta venta');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function giftItem($id)
    {
        try{
            $this->authorize('sell', User::class);
            $item = SaleDetail::findOrFail($id);
            $item->gift = 1;
            $item->price = 0;
            $item->save();
            return response()->json('Item marcado como regalo exitosamente');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function updateItem($itemId, $itemQty)
    {
        try{
            $this->authorize('sell', User::class);
            $item = SaleDetail::findOrfail($itemId);
            $productAvailable = Stock::findOrFail($item->stock_id);

            if ($itemQty > $productAvailable->qty){
                return response()->json('La cantidad es mayor a la disponible.',401);
            }
            $UnitPrice = $item->price / $item->qty;
            $UnitCostPrice = $item->cost_price / $item->qty;
            $item->qty = $itemQty;
            $item->price = $UnitPrice * $itemQty;
            $item->cost_price = $UnitCostPrice * $itemQty;
            $item->save();
            return response()->json('Cantidad actualizada');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function addPaymentToSale(Request $request)
    {
        try{
            $this->authorize('sell', User::class);
            $checkDetails = SaleDetail::where('sale_id', $request->sale_id)->get();
            if ($checkDetails->count() == 0){
                return response()->json('No puede agregar un pago si la venta no tiene productos agregados',401);
            }
            $checkMethod = Payment::where('payment_method_id', $request->payment_method_id)
                ->where('sale_id', $request->sale_id)->first();
            if($checkMethod){
                $payment = $checkMethod;
                $payment->amount += $request->amount;
            }else{
                $payment = new Payment();
                $payment->fill($request->all());
                $payment->created_by = Auth::id();
            }

            if($request->payment_method_id == 2){
                $checkLoan = Loan::where('sale_id', $request->sale_id)->first();
                if($checkLoan){
                    $loan = $checkLoan;
                    $loan->amount += $request->amount;
                }else{
                    $loan = new Loan();
                    $loan->client_id = $request->client_id;
                    $loan->sale_id = $request->sale_id;
                    $loan->amount = $request->amount;
                    $loan->comment = 'Agregado automáticamente en la venta #'.$request->sale_id;
                    $loan->created_by = Auth::id();
                }
                $loan->save();
            }
            if ($request->amount_bs){
                $payment->amount_bs = $request->amount_bs;
                $payment->comment = $payment->comment.' (Bs. '.number_format($request->amount_bs,2,',','.').')';
            }
            $payment->save();

            return response()->json('Pago agregado');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function addAllPaymentToSale($saleId, $methodId)
    {
        try{
            $this->authorize('sell', User::class);
            $checkDetails = SaleDetail::where('sale_id', $saleId)->get();
            $sale = Sale::find($saleId);
            if ($checkDetails->count() == 0){
                return response()->json('No puede agregar un pago si la venta no tiene productos agregados',401);
            }
            $saleTotal = $checkDetails->sum('price') - $sale->payments->where('payment_method_id', '<>', $methodId)->sum('amount');
            $checkMethod = Payment::where('payment_method_id', $methodId)
                ->where('sale_id', $saleId)->first();
            if($checkMethod){
                $payment = $checkMethod;
                $payment->amount = $saleTotal;
            }else{
                $payment = new Payment();
                $payment->sale_id = $saleId;
                $payment->client_id = $sale->client_id;
                $payment->payment_method_id = $methodId;
                $payment->amount = $saleTotal;
                $payment->created_by = Auth::id();
            }

            if($methodId == 2){
                $checkLoan = Loan::where('sale_id', $saleId)->first();
                if($checkLoan){
                    $loan = $checkLoan;
                    $loan->amount = $saleTotal;
                }else{
                    $loan = new Loan();
                    $loan->client_id = $sale->client_id;
                    $loan->sale_id = $saleId;
                    $loan->amount = $saleTotal;
                    $loan->comment = 'Agregado automáticamente en la venta #'.$saleId;
                    $loan->created_by = Auth::id();
                }
                $loan->save();
            }
            $payment->save();
            return response()->json('Pago total agregado');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function deletePaymentToSale($itemId)
    {
        try{
            $this->authorize('sell', User::class);
            $payment = Payment::findOrFail($itemId);
            if ($payment->payment_method_id == 1){
                Deposit::where('claimed_in_sale_id', $payment->sale_id)
                    ->update(['claimed' => NULL, 'claimed_in_sale_id' => NULL]);
            }
            if ($payment->payment_method_id == 2){
                Loan::where('sale_id', $payment->sale_id)->delete();
            }
            $payment->delete();
            return response()->json('Pago eliminado');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function changeItemPrice(Request $request)
    {
        try{
            $this->authorize('sell', User::class);
            $rolesWithPermission = Rol::where('p_discount', 1)->pluck('id')->toArray();
            $users = User::whereIn('rol_id', $rolesWithPermission)->get();

            foreach ($users as $user){
                $validUser = Hash::check($request->password, $user->password);
                if ($validUser){
                    $detail = SaleDetail::findOrFail($request->item_id);
                    $detail->price = $request->item_price;
                    $detail->authorized_by = $user->id;
                    $detail->save();
                    return response()->json('Precio actualizado');
                }
            }
            return response()->json('Contraseña incorrecta. No se ha podido cambiar el precio.',401);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }

    public function changeItemPriceFull(Request $request)
    {
        try{
            $detail = SaleDetail::findOrFail($request->item_id);
            $detail->price = $request->item_price;
            $detail->authorized_by = Auth::id();
            $detail->save();
            return response()->json('Precio actualizado');
        }catch (\Exception $e){
            return response()->json($e->getMessage(),401);
        }
    }


    public function procSale(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->authorize('sell', User::class);
            $sale = Sale::findOrFail($request->sale_id);
            if ($sale->details->count() == 0){
                return back()->with('error', 'Faltan datos (artículos) necesarios para procesar la venta');
            }
            $saleTotal = $sale->details->sum('price');
            $paymentsNoLoans = $sale->payments->where('payment_method_id', '<>', 2)->sum('amount');
            $saleSurplus = $paymentsNoLoans - $saleTotal;
            if($saleSurplus > 0){
                $loans = Loan::where('client_id', $sale->client_id)->where('closed', 0)->get();
                if(count($loans) > 0){
                    foreach($loans as $loan){
                        $loanLeft = $loan->amount - $loan->payments->sum('amount');
                        if($saleSurplus >= $loanLeft){
                            $amountToAdd = $loanLeft;
                            $saleSurplus -= $loanLeft;
                            $loan->closed = 1;
                            $loan->save();
                        }else{
                            $amountToAdd = $saleSurplus;
                            $saleSurplus = 0;
                        }
                        $loanPayment = new LoanPayment;
                        $loanPayment->loan_id = $loan->id;
                        $loanPayment->amount = $amountToAdd;
                        $loanPayment->save();
                        if($saleSurplus == 0){ break;}
                    }
                }
                if($saleSurplus > 0){
                    $creditAmount = $saleSurplus;
                    $credit = new Deposit();
                    $credit->client_id = $sale->client_id;
                    $credit->sale_id = $sale->id;
                    $credit->amount = $creditAmount;
                    $credit->comment = 'Agregado automáticamente como excedente de la venta: #'.$sale->id;
                    $credit->created_by = Auth::id();
                    $credit->save();
                }
            }
            $sale->comment = $request->comment;
            if(!empty($request->created_by)){
                $sale->created_by = $request->created_by;
            }else{
                $sale->created_by = Auth::id();
            }
            $sale->sale_status_id = 2;
            foreach ($sale->details as $detail){
                StockUtils::updateStock($detail);
            }
            $sale->amount = $sale->details->sum('price');
            if($request->closed_at){
                $sale->closed_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->closed_at. ' 00:00:01');
            }else{
                $sale->closed_at = Carbon::now();
            }
            $sale->save();
            DB::commit();
            return redirect('/ventas')->with('message', 'Venta creada exitosamente');
        }catch (\Exception $e){
            DB::rollBack();
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function sales(Request $request)
    {
        try{
            $this->authorize('sales', User::class);
            $this->setSeo('Ventas registradas');
            $query = $request->searchquery ? : '';
            $data['sales'] = Sale::search(['id', 'client.name', 'amount', 'closed_at'], $query)->orderBy('id', 'desc')
            ->with('client')->with('details')->with('status')->paginate(30);
            if($query){
                $data['sales']->appends(['searchquery' => $request->searchquery]);
            }
            if ($request->ajax()) {
                return view('modules.sales.partials.recordsTable', $data)->render();
            }
            return view('modules.sales.list', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    // public function getFilteredSales(Request $request)
    // {
    //     try{
    //         $this->authorize('sales', User::class);
    //         $query = $request->searchquery ? : '';
    //         if(empty($query)){
    //             $data['sales'] = Sale::orderBy('id', 'desc')->paginate(30);
    //         }else{
    //             $data['sales'] = Sale::search(['id', 'client.name', 'amount', 'closed_at'], $query)->orderby('id', 'desc')->take(100)->get();
    //         }
    //         return view('modules.sales.partials.recordsTable', $data);
    //         // return json_encode($sales);
    //     }catch (\Exception $e){
    //         return view('errors.exception')->with('error', $e->getMessage());
    //     }
    // }


    public function viewSale($idc)
    {
        try{
            $this->authorize('sales', User::class);
            $id = base64_decode($idc);
            $data['sale'] = Sale::findOrFail($id);
            $data['details'] = SaleDetail::where('sale_id', $id)->get();
            $data['saleTotal'] = $data['details']->sum('price');
            $this->setSeo('Viendo venta de: '.$data['sale']->client->name);
            return view('modules.sales.view', $data);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function returnItem(Request $request)
    {
        try{
            DB::beginTransaction();
            $this->authorize('sales', User::class);
            $detail = SaleDetail::findOrFail($request->detail_id);
            $detail->returned = 1;
            $detail->returned_reason = $request->comment;
            $detail->save();
            if($request->return_stock == 1){
                StockUtils::updateStock($detail, true);
            }
            if($request->return_payment == 1){
                $payment = new Payment();
                $payment->sale_id = $detail->sale_id;
                $payment->client_id = $detail->sale->client_id;
                $payment->payment_method_id = 5;
                $payment->amount = -$detail->price;
                $payment->comment = $request->comment;
                $payment->created_by = 1;
                $payment->save();
                SaleDetail::where('id', $request->detail_id)->update([
                    'price' => 0, 'cost_price' => 0, 'qty' => 0,
                ]);
                $sale = Sale::FindOrFail($detail->sale_id);
                $sale->amount -= $detail->price;
                $sale->comment .= ' (con devoluciones)';
                $sale->save();
            }
            DB::commit();
            return back()->with('message', 'El item se ha devuelto correctamente');
        }catch (\Exception $e){
            DB::rollBack();
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function changeDefault($warehouse_id, Request $request){
        try{
            $this->authorize('sales', User::class);
            Warehouse::where('is_default', 1)->update(['is_default' => null]);
            $data = Warehouse::findOrFail($warehouse_id);
            $data->is_default = 1;
            $data->save();
            $request->session()->flash('message', "Almacén cambiado a: <strong>".$data->name . "</strong>");
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

}
