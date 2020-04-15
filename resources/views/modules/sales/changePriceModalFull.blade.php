<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/2/2019
 * Time: 7:48 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="changePriceModalFull" role="dialog" aria-labelledby="changePriceModalFull" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-grey">
                <label class="modal-title text-text-bold-600" id="changePriceModalFull"><h3 class="text-white modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'venta/changeItemPriceFull', 'method' => 'post', 'id' => 'changePriceFormFull', 'class' => 'changePriceForm']) }}
            <div class="modal-body">
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
                <input type="reset" class="btn btn-outline-grey btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-grey btn-lg addbutton">Actualizar
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
