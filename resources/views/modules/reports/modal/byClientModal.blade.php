<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/1/19
 * Time: 2:37 AM
 */?>
<div class="modal animated bounceInLeft text-left" id="byClientModal" role="dialog" aria-labelledby="byClientModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-indigo">
                <label class="modal-title text-text-bold-600" id="byClientModal"><h3 class="text-white">Generar por cliente</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'report.byClient', 'method' => 'post']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="client_id" class="filled">Cliente:<span class="text-danger">*</span></label>
                            <select class="input-xl select2-ajax-clients form-control" id="" name="client_id" required></select>
                        </fieldset>
                    </div>
                </div>
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
                <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-indigo btn-lg ld-ext-right">Generar
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
