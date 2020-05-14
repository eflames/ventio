<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/1/19
 * Time: 2:37 AM
 */?>
<div class="modal animated bounceInUp text-left report-modal" id="byTypeModal" role="dialog" aria-labelledby="byTypeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="byTypeModal"><h3 class="mb-0">Generar flujo de caja</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'report.byType', 'method' => 'post']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <fieldset class="form-group form-group-style">
                            <label for="name" class="filled">Desde:</label>
                            {{ Form::date('date_from', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </fieldset>
                    </div>
                    <div class="col-6">
                        <fieldset class="form-group form-group-style">
                            <label for="name" class="filled">Hasta:</label>
                            {{ Form::date('date_to', null, ['class' => 'form-control', 'id' => 'name']) }}
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
