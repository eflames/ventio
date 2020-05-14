<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left modal-ware" id="editWareModal" role="dialog" aria-labelledby="editWareModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="editWareModal"><h3 class="mb-0 modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'almacenes/editar', 'method' => 'put']) }}
                <div class="modal-body">
                    @include('modules.warehouses.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-pink btn-lg ld-ext-right">Actualizar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::hidden('warehouse_id', null, ['class' => 'form-control', 'id' => 'warehouse_id']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
