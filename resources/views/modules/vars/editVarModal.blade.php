<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left modal-conf" id="editVarModal" role="dialog" aria-labelledby="editVarModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="editVarModal"><h3 class="mb-0 modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'config.update', 'method' => 'put']) }}
                <div class="modal-body">
                    @include('modules.vars.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-pink btn-lg ld-ext-right">Actualizar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::hidden('var_id', null, ['class' => 'form-control', 'id' => 'var_id']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
