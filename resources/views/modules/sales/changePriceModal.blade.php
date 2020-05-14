<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/2/2019
 * Time: 7:48 PM
 */?>

<div class="modal animated bounceInUp text-left" id="changePriceModal" role="dialog" aria-labelledby="changePriceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="changePriceModal"><h3 class="mb-0 modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'venta/changeItemPrice', 'method' => 'post', 'id' => 'changePriceForm', 'class' => 'changePriceForm']) }}
            <div class="modal-body">
                <div class="row pb-3">
                    <div class="col-12 text-center">
                        <p><span class="fa fa-lock fa-3x red"></span></p>
                        <span class="red">NOTA:</span> Cambiar el precio de un artículo en la pantalla de ventas está sólo disponible
                        por permisos especiales, por favor, ingrese la contraseña de algún usuario con el permiso
                        <strong>"DESCUENTOS"</strong> asignado
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="password" class="filled">Contraseña: <span class="text-danger">*</span></label>
                            {{ Form::password('password', ['class' => 'form-control', 'required' => true]) }}
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="item_price" class="filled">Precio: <span class="text-danger">*</span></label>
                            {{ Form::text('item_price', null, ['class' => 'form-control', 'id' => 'item_price', 'required' => true]) }}
                            {{ Form::hidden('sale_id', $sale->id, ['id' => 'sale_id']) }}
                            {{ Form::hidden('item_id', null, ['id' => 'item_id']) }}
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-outline-indigo btn-lg addbutton">Actualizar
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
