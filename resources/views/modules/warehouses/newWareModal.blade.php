<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left modal-ware" id="newWareModal" role="dialog" aria-labelledby="newCatModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="newWareModal"><h3 class="mb-0">Nuevo almacén</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'almacenes', 'method' => 'post']) }}
                <div class="modal-body">
                    @include('modules.warehouses.partials._formModal')
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="pb-1">
                                <input type="checkbox" class="js-switch" name="is_default" value="1" />
                                <label for="is_default" class="font-medium-1 text-bold-400 ml-1">¿predeterminado?</label>
                            </div>
                        </div>
                    </div>
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
