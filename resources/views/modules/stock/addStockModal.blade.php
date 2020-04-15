<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="addStockModal" role="dialog" aria-labelledby="addStockModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <label class="modal-title text-text-bold-600" id="addStockModal">
                    <h3 class="text-white modal-title-changed">
                        Agregar nuevo stock
                    </h3>
                </label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'stock.store', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group form-group-style">
                                <label for="product_id" class="filled">Producto: <span class="text-danger">*</span></label>
                                <select class="select2-ajax-products form-control" id="" name="product_id"></select>
                                @if ($errors->has('product_id'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('product_id') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group form-group-style">
                                <label for="selectOpt" class="filled">Almacén: <span class="text-danger">*</span></label>
                                {{ Form::select('warehouse_id', [''=>'Seleccione almacén...'] + $warehouses->toArray(), null, ['class' => 'form-control', 'id' => 'selectOpt']) }}
                                @if ($errors->has('warehouse_id'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('warehouse_id') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <fieldset class="form-group form-group-style">
                                <label for="qty" class="filled">Cantidad: <span class="text-danger">*</span></label>
                                {{ Form::text('qty', null, ['class' => 'form-control']) }}
                                @if ($errors->has('qty'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('qty') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Precio venta: <span class="text-danger">*</span></label>
                                {{ Form::text('price', null, ['class' => 'form-control']) }}
                                @if ($errors->has('price'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('price') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                        <div class="col-4">
                            <fieldset class="form-group form-group-style">
                                <label for="cost_price" class="filled">Precio costo: <span class="text-danger">*</span></label>
                                {{ Form::text('cost_price', null, ['class' => 'form-control']) }}
                                @if ($errors->has('cost_price'))
                                    <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('cost_price') }}</small></p>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-green btn-lg ld-ext-right">Agregar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
