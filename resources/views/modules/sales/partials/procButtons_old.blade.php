<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/9/2019
 * Time: 12:02 AM
 */?>
@if(count($sale->client->activeLoans) > 0)
    @include('modules.sales.partials.loanWarning')
@endif
Lo que debe el carajo {{$sale->client->activeLoans->sum('amount')}}
Restante {{ ($sale->payments->sum('amount') - $saleTotal) }}
<div class="row mb-3">
    <div class="col-12 text-center">
        @if($sale->details->count() > 0)
            @if($saleTotal > $sale->payments->sum('amount'))
                <button class="btn btn-grey btn-lg btn-block box-shadow-2" disabled>
                    <span class="fa fa-check"></span> Faltan pagos para procesar
                </button>
            @else
                @if(count($sale->client->activeLoans) == 0)
                    <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                            data-tooltip="tooltip" data-placement="top" title="
                            @if($saleTotal < $sale->payments->sum('amount'))
                            Procesar venta y abonar excedente como crédito
                            @elseif($saleTotal == $sale->payments->sum('amount'))
                            Procesar venta
                            @endif"
                            data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                        <span class="fa fa-check"></span>
                        @if($saleTotal < $sale->payments->sum('amount'))
                            Procesar venta/abonar crédito
                        @elseif($saleTotal == $sale->payments->sum('amount'))
                            Procesar venta
                        @endif
                    </button>
                @else
                    <button class="btn btn-grey-blue btn-lg btn-block box-shadow-2"
                            data-tooltip="tooltip" data-placement="top" title="
                            @if(($sale->payments->sum('amount') - $saleTotal) < $sale->client->activeLoans->sum('amount'))
                                Procesar venta y abonar excedente a deuda del cliente
                            @else
                                Procesar venta, abonar a deuda y excedente a crédito
                            @endif" data-toggle="modal" data-target="#procSaleModal" accesskey="v">
                        <span class="fa fa-check"></span>
                        @if(($sale->payments->sum('amount') - $saleTotal) < $sale->client->activeLoans->where('sale_id', '<>', $sale->id)->sum('amount'))
                            Procesar venta y abonar a deuda
                        @else
                            Procesar venta, abonar a deuda y crédito
                        @endif
                    </button>
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