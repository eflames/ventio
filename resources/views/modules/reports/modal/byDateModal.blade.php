<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/1/19
 * Time: 2:37 AM
 */?>
<div class="modal animated bounceInLeft text-left" id="byDateModal" role="dialog" aria-labelledby="byDateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-indigo">
                <label class="modal-title text-text-bold-600" id="byDateModal"><h3 class="text-white">Generar por fecha</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'report.byDate', 'method' => 'post']) }}
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
                <div class="row pt-1">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="selectOpt" class="filled">Vendedor:</label>
                            {{ Form::select('created_by', ['' => 'Todos'] + $sellers->toArray(), null, ['class' => 'form-control']) }}
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
