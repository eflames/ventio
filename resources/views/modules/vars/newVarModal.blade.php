<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="newVarModal" role="dialog" aria-labelledby="newVarModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <label class="modal-title text-text-bold-600" id="newVarModal"><h3 class="text-white">Nueva variable</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'config.store', 'method' => 'post']) }}
                <div class="modal-body">
                    @include('modules.vars.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-pink btn-lg ld-ext-right">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
