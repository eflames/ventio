<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left config-modal" id="newCatModal" role="dialog" aria-labelledby="newCatModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="newCatModal"><h3 class="mb-0">Nueva categoría</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'categorias', 'method' => 'post']) }}
                <div class="modal-body">
                    @include('modules.categories.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-pink btn-lg ld-ext-right">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
