<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="newSaleModal" role="dialog" aria-labelledby="newSaleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-grey-blue">
                <label class="modal-title text-text-bold-600" idw="newSaleModal"><h3 class="text-white">Nueva venta</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'ventas/create', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">Puedes buscar por <strong>Nombre, Cédula o Teléfono</strong></p>
                            <fieldset class="form-group form-group-style">
                                <label for="id_number" class="filled">Cliente:<span class="text-danger">*</span></label>
                                <select class="input-xl select2-ajax-clients form-control" id="" name="client_id" required></select>
                            </fieldset>
                            <p>
                                <button type="submit" class="btn btn-grey-blue btn-lg ld-ext-right btn-block">Iniciar venta
                                    <div class="ld ld-ring ld-spin"></div>
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center col-12">
                            <p class="text-bold-700">Ó</p>
                            <p>Puedes crear un cliente nuevo</p>
                            <button type="button" class="btn btn-outline-cyan btn-lg btn-block" data-toggle="modal"
                                    data-target="#newClientModal" data-dismiss="modal">Nuevo cliente
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-grey btn-lg" data-dismiss="modal" value="Cancelar">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
