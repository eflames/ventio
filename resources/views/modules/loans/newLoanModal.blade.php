<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="newLoanModal" role="dialog" aria-labelledby="newLoanModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-orange bg-darken-2">
                <label class="modal-title text-text-bold-600" idw="newLoanModal"><h3 class="text-white">Agregar deuda manualmente</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'loans.create', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">Puedes buscar por <strong>Nombre, Cédula o Teléfono</strong></p>
                            <fieldset class="form-group form-group-style">
                                <label for="id_number" class="filled">Cliente:<span class="text-danger">*</span></label>
                                <select class="input-xl select2-ajax-clients form-control" id="" name="client_id" required></select>
                            </fieldset>
                            <fieldset class="form-group form-group-style">
                                <label for="amount" class="filled">Monto:<span class="text-danger">*</span></label>
                                {{ Form::text('amount', null, ['class' => 'form-control', 'required' => true]) }}
                            </fieldset>
                            <fieldset class="form-group form-group-style">
                                <label for="comment" class="filled">Comentario:</label>
                                {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 5]) }}
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-orange btn-lg ld-ext-right btn-darken-2">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
