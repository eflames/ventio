<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/2/2019
 * Time: 7:48 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="newPaymentModal" role="dialog" aria-labelledby="newPaymentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <label class="modal-title text-text-bold-600" id="newPaymentModal"><h3 class="text-white">Agregar pago</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'venta/addPayment', 'method' => 'post', 'class' => 'AddItemForm', 'data-focus' => 'payment_method_id']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <fieldset class="form-group form-group-style">
                            <label for="payment_method_id" class="filled">Método:<span class="text-danger">*</span></label>
                            {{ Form::select('payment_method_id', [''=>'Seleccione método...'] + $paymentMethods->toArray(), null, ['class' => 'form-control', 'id' => 'selectOpt', 'required' => true]) }}
                            <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale->id }}">
                            {{ Form::hidden('client_id', $sale->client->id) }}
                        </fieldset>
                    </div>
                    <div class="col-4">
                        <fieldset class="form-group form-group-style">
                            <label for="amount" class="filled">Monto:<span class="text-danger">*</span></label>
                            {{ Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'step' => 'any', 'id' => 'amount_usd']) }}
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="comment" class="filled">Comentario:</label>
                            {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'comment', 'rows' => 3]) }}
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div id="closedOptionBar"><a href="javascript:showBsField()" class="btn btn-sm btn-indigo"><span class="fa fa-plus-circle"></span> ¿Pago en Bs.?</a></div>
                        <div id="openedOptionBar" style="display: none">
                            <a href="javascript:recalculateBsField()" class="btn btn-sm btn-outline-dark"><span class="fa fa-refresh"></span> Recalcular</a>
                            <a href="javascript:closeBsField()" class="btn btn-sm btn-outline-red"><span class="fa fa-times"></span> Cancelar</a>
                        </div>
                    </div>
                </div>

                <div class="row pt-1" id="bsDiv" style="display: none">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="selectOpt" class="filled">Monto en bs:</label>
                            {{ Form::number('amount_bs', null, ['class' => 'form-control', 'id' => 'amount_bs']) }}
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-grey btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-success btn-lg ld-ext-right" id="addPaymentButton">Agregar
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
