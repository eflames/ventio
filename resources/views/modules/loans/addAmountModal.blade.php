<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="addAmountModal" role="dialog" aria-labelledby="addAmountModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-grey">
                <label class="modal-title text-text-bold-600" id="addAmountModal"><h3 class="text-white modal-title-changed">Abonar a crédito por cobrar</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'loans.addAmount', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Monto a abonar: <span class="text-danger">*</span></label>
                                {{ Form::number('amount', null, ['class' => 'form-control', 'step' => 'any', 'required' => true]) }}
                            </fieldset>
                            {{ Form::hidden('credit_id', null, ['id' => 'credit_id']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Método de pago: <span class="text-danger">*</span></label>
                                {{ Form::select('payment_method_id', ['' => 'Seleccione un método...'] + $paymentMethods->toArray(), null, ['class' => 'select2 form-control', 'step' => 'any', 'required' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-orange btn-lg ld-ext-right">
                        <span class="fa fa-plus"></span> Abonar <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
