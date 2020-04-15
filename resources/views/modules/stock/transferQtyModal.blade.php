<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="transferQtyModal" role="dialog" aria-labelledby="transferQtyModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <label class="modal-title text-text-bold-600" id="transferQtyModal"><h3 class="text-white modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'stock/transfer', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="fromWarehouse" class="filled">Desde: <span class="text-danger">*</span></label>
                                {{ Form::text('fromWarehouse', null, ['class' => 'form-control', 'id' => 'fromWarehouse', 'disabled' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <fieldset class="form-group form-group-style">
                                <label for="selectOpt" class="filled">Hacia: <span class="text-danger">*</span></label>
                                {{ Form::select('warehouse_id', [''=>'Seleccione almacén...'] + $warehouses->toArray(), null, ['class' => 'form-control', 'id' => 'selectOpt', 'required' => true]) }}
                                @if ($errors->has('warehouse_id'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('warehouse_id') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-5">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Cantidad: <span class="text-danger">*</span></label>
                                {{ Form::number('qty', null, ['class' => 'form-control', 'id' => 'qty']) }}
                            </fieldset>
                            {{ Form::hidden('stock_id', null, ['id' => 'stock_id']) }}
                            {{ Form::hidden('product_id', null, ['id' => 'product_id']) }}
                            {{ Form::hidden('from_warehouse_id', null, ['id' => 'from_warehouse_id']) }}
                            {{ Form::hidden('name', null, ['id' => 'name']) }}
                            {{ Form::hidden('warehousename', null, ['id' => 'warehousename']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-green btn-lg ld-ext-right">Transferir
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
