<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left" id="addQtyModal" role="dialog" aria-labelledby="addQtyModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="addQtyModal"><h3 class="modal-title-changed mb-0"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'stock/addQty', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="price" class="filled">Cantidad a agregar: <span class="text-danger">*</span></label>
                                {{ Form::text('qty', null, ['class' => 'form-control', 'id' => 'qty']) }}
                            </fieldset>
                            {{ Form::hidden('stock_id', null, ['id' => 'stock_id']) }}
                            {{ Form::hidden('name', null, ['id' => 'name']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-light-green btn-lg ld-ext-right">Añadir
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
