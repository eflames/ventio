<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/9/2019
 * Time: 12:02 AM
 */
$payments = $sale->payments->sum('amount');
$paymentsNoLoans = $sale->payments->where('payment_method_id', '<>', 2)->sum('amount');
$saleSurplus = $paymentsNoLoans - $saleTotal;
$clientLoans = App\Libraries\LoanUtils::getClientLoansTotalButThisSale($sale->client->id, $sale->id);
?>
@if(count($sale->client->activeLoans) > 0)
    @include('modules.sales.partials.loanWarning')
@endif

<div class="row mb-3">
    <div class="col-12 text-center">
        @if($saleTotal > $payments)
            <button class="btn btn-grey btn-lg btn-block box-shadow-2" disabled>
                <span class="fa fa-check"></span> Faltan pagos para procesar
            </button>
        @else
            @if($sale->details->count() > 0)
                @if($clientLoans == 0)
                    @if($payments == $saleTotal)
                        <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                data-tooltip="tooltip" data-placement="top" title="Procesar"
                                data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                            <span class="fa fa-check"></span>
                            Procesar
                        </button>
                    @elseif($paymentsNoLoans > $saleTotal)
                        <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                data-tooltip="tooltip" data-placement="top" title="Procesar, abonar credito"
                                data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                            <span class="fa fa-check"></span>
                            Procesar, abonar credito
                        </button>
                    @endif
                @else
                    @if($saleSurplus > 0)
                        @if($saleSurplus > $clientLoans)
                            <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                    data-tooltip="tooltip" data-placement="top" title="Procesar, abonar a deuda y credito"
                                    data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                                <span class="fa fa-check"></span>
                                Procesar, abonar a deuda y credito
                            </button>
                        @elseif($saleSurplus <= $clientLoans)
                            <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                    data-tooltip="tooltip" data-placement="top" title="Procesar y abonar a deuda"
                                    data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                                <span class="fa fa-check"></span>
                                Procesar y abonar a deuda
                            </button>
                        @endif
                    @else
                        @if($paymentsNoLoans == $saleTotal)
                            <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                    data-tooltip="tooltip" data-placement="top" title="Procesar"
                                    data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                                <span class="fa fa-check"></span>
                                Procesar
                            </button>
                        @else
                            <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                                    data-tooltip="tooltip" data-placement="top" title="Procesar y cargar a deuda"
                                    data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                                <span class="fa fa-check"></span>
                                Procesar y cargar a deuda
                            </button>
                        @endif
                    @endif
                @endif
            @endif


















        @endif
        {{ Form::open(['url' => 'venta/delete/'.$sale->id, 'method' => 'post', 'id'=>'formelim-'.$sale->id, 'class' => 'pt-1']) }}
        <button class="btn btn-outline-red btn-lg btn-block box-shadow-2" type="button" onclick="alertElim('{{ $sale->id }}')"
                data-tooltip="tooltip" data-placement="bottom" title="Cancelar y eliminar venta" accesskey="c">
            <span class="fa fa-remove"></span> Cancelar
        </button>
        {{ Form::open() }}
    </div>
</div>