<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left" id="newPaymentModal" role="dialog" aria-labelledby="newPaymentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light bg-darken-3">
                <label class="modal-title text-text-bold-600" idw="newPaymentModal"><h3 class="mb-0">Registrar pago de deuda</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'loans.payment', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">Puedes buscar por <strong>Nombre, Cédula o Teléfono</strong></p>
                            <fieldset class="form-group form-group-style">
                                <label for="id_number" class="filled">Cliente:<span class="text-danger">*</span></label>
                                <select class="input-xl select2-ajax-clients form-control" id="client_id" name="client_id" required onchange="showAmount();"></select>
                            </fieldset>
                            <fieldset class="form-group form-group-style">
                                <label for="amount" class="filled">Monto a abonar:<span class="text-danger">*</span></label>
                                {{ Form::text('amount', null, ['class' => 'form-control', 'required' => true]) }}
                            </fieldset>
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Método de pago: <span class="text-danger">*</span></label>
                                {{ Form::select('payment_method_id', ['' => 'Seleccione un método...'] + $paymentMethods->toArray(), null, ['class' => 'select2 form-control', 'step' => 'any', 'required' => true]) }}
                            </fieldset>

                            <div class="alert alert-light">
                                <div id="amountDiv" class="text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-orange btn-lg ld-ext-right btn-darken-3">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
