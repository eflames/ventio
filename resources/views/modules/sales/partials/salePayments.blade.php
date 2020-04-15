<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/9/2019
 * Time: 12:05 AM
 */
$payments = $sale->payments->sum('amount');
$paymentsNoLoans = $sale->payments->where('payment_method_id', '<>', 2)->sum('amount');
$saleSurplus = $paymentsNoLoans - $saleTotal;
$clientActiveLoansWithoutPayments = $sale->client->activeLoans->where('sale_id', '<>', $sale->id)->sum('amount');
$clientActiveLoansPayments = $sale->client->activeLoansPayments->sum('amount');
$clientLoans = App\Libraries\LoanUtils::getClientLoansTotalButThisSale($sale->client->id, $sale->id);
?>
<div class="card-content">
    <div class="card-body">
        @if($sale->payments->count() > 0)
            <p>Progreso del pago:
                @if($saleTotal > $sale->payments->sum('amount'))
                    <span class="float-right">Restan: <strong>${{ number_format($saleTotal - $sale->payments->sum('amount'), 2) }}</strong></span>
                @elseif($saleTotal < $sale->payments->sum('amount'))
                    @if($clientLoans == 0)
                        @if($paymentsNoLoans > $saleTotal)
                            <span class="float-right">Procesar, abonar credito: <strong>${{ number_format(abs($saleTotal - $paymentsNoLoans), 2) }}</strong></span>
                        @endif
                    @elseif($clientLoans > 0)
                        @if($saleSurplus > 0)
                            @if($saleSurplus > $clientLoans)
                                <span class="float-right">Procesar, abonar a deuda y agregar a credito: <strong>${{ number_format(abs($paymentsNoLoans - ($saleTotal + $clientLoans) ), 2) }}</strong></span>
                            @elseif($saleSurplus <= $clientLoans)
                                <span class="float-right">Procesar y abonar a deuda: <strong>${{ number_format(abs($saleTotal - $paymentsNoLoans), 2) }}</strong></span>
                            @endif
                        @endif
                    @endif
                @endif
            </p>
            <div class="progress">
                <div class="progress-bar @if($paymentPercentage >= 100) bg-grey-blue @else bg-success @endif"
                     role="progressbar" style="width: {{ $paymentPercentage }}%;" aria-valuenow="25"
                     aria-valuemin="0" aria-valuemax="100">{{ $paymentPercentage }}%</div>
            </div>
            <table class="table">
                <thead>
                <tr class="bg-success white">
                    <th class="text-center">Fecha</th>
                    <th>Método</th>
                    <th class="text-center">Commentario</th>
                    <th class="text-right">Monto</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sale->payments as $payment)
                    <tr>
                        <td class="text-center">{{ $payment->created_at->format('d/m/Y') }}</td>
                        <td><strong>{{ $payment->method->name }}</strong>
                            <a href="#" onclick="deleteItem({{ $payment->id }},{{ $payment->sale->id }},'/api/venta/deletePayment/', '#paymentItems')"
                            data-tooltip="tooltip" data-placement="right" title="Elimnar este item">
                            <span class="fa fa-remove"></span>
                            </a>
                        </td>
                        <td class="text-right">{{ $payment->comment }}</td>
                        <td class="text-right">${{ number_format($payment->amount,2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total pagado:</strong></td>
                    <td class="text-right"><strong>${{ number_format($sale->payments->sum('amount'), 2) }}</strong></td>
                </tr>
                </tbody>
            </table>
        @else
            <p class="text-center">No hay pagos ingresados para esta venta aun</p>
        @endif
        <div class="text-center">
            <div class="btn-group mr-1 mb-1">
                <button class="btn btn-success" data-toggle="modal" data-target="#newPaymentModal" accesskey="p">
                    <span class="fa fa-plus"></span> Agregar
                </button>
            </div>
            <div class="btn-group mr-1 mb-1">
                <button type="button" class="btn btn-success btn-darken-3 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus-circle"></i> Pago completo</button>
                <div class="dropdown-menu">
                    @foreach($paymentMethods as $key => $value)
                        <a href="#" class="dropdown-item" onclick="addAllPayment({{ $sale->id }},{{ $key }})">{{ $value }}</a>
                        {{--<button type="submit" class="dropdown-item">{{ $value }}</button>--}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
