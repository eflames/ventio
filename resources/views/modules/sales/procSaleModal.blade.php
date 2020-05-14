<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/2/2019
 * Time: 7:48 PM
 */?>

<div class="modal animated bounceInUp text-left" id="procSaleModal" role="dialog" aria-labelledby="procSaleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="procSaleModal"><h3 class="mb-0">¿Procesar venta?</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'venta/procSale', 'method' => 'post', 'onsubmit' => 'procSaleSubmit.disabled = true; return true;']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="comment" class="filled">Comentario: (opcional)</label>
                            {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'SaleComment', 'rows' => 3]) }}
                            {{ Form::hidden('sale_id', $sale->id, ['id' => 'sale_id_sale']) }}
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5><span class="grey">Vendedor:</span> {{ $sale->seller->name }}</h5>
                                <a href="javascript:changeSeller()" class="btn btn-sm btn-outline-grey-blue">Cambiar vendedor</a>
                            </div>
                        </div>
                        <div class="row pt-1" id="sellerDiv" style="display: none">
                            <div class="col-12">
                                <fieldset class="form-group form-group-style">
                                    <label for="selectOpt" class="filled">Vendedor:</label>
                                    {{ Form::select('created_by', [''=>'Seleccione vendedor...'] + $sellers->toArray(), null, ['class' => 'form-control']) }}
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5><span class="grey">Procesar en fecha:</span> {{ date('d/m/Y') }}</h5>
                                <a href="javascript:changeDate()" class="btn btn-sm btn-outline-grey-blue">Cambiar fecha</a>
                            </div>
                        </div>
                        <div class="row pt-1" id="dateDiv" style="display: none">
                            <div class="col-12">
                                <fieldset class="form-group form-group-style">
                                    <label for="selectOpt" class="filled">Fecha:</label>
                                    {{ Form::date('closed_at', null, ['class' => 'form-control']) }}
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" id="procSaleSubmit" class="btn btn-grey-blue btn-lg ld-ext-right">Si, procesar
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
