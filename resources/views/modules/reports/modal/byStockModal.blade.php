<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/1/19
 * Time: 2:37 AM
 */?>
<div class="modal animated bounceInUp text-left report-modal" id="byStockModal" role="dialog" aria-labelledby="byStockModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="byStockModal"><h3 class="mb-0">Generar todo el stock</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'report.byStock', 'method' => 'post']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="warehouse_id" class="filled">Almacén: <span class="text-danger">*</span></label>
                            {{ Form::select('warehouse_id', ['' => 'Todos los almacenes..'] + $warehouses->toArray(), null, ['class' => 'form-control'] ) }}
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-indigo btn-lg ld-ext-right">Generar
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
