<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="editPriceModal" role="dialog" aria-labelledby="editPriceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green bg-darken-3">
                <label class="modal-title text-text-bold-600" id="editPriceModal"><h3 class="text-white modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'stock/editPrice', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Precio venta: <span class="text-danger">*</span></label>
                                {{ Form::text('price', null, ['class' => 'form-control', 'id' => 'price', 'required' => true]) }}
                            </fieldset>
                            {{ Form::hidden('stock_id', null, ['id' => 'stock_id']) }}
                            {{ Form::hidden('name', null, ['id' => 'name']) }}
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group form-group-style">
                                <label for="cost_price" class="filled">Precio costo: <span class="text-danger">*</span></label>
                                {{ Form::text('cost_price', null, ['class' => 'form-control', 'id' => 'cost_price', 'required' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-green btn-darken-3 btn-lg ld-ext-right">Modificar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
