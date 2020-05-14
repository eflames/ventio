<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left masterModal" id="newClientModal" role="dialog" aria-labelledby="newClientModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="newClientModal"><h3 class="mb-0">Crear cliente rápido</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'clientes/fast', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            <span class="text-danger">*</span> son campos obligatorios
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="name" class="filled">Nombre<span class="text-danger">*</span></label>
                                {{ Form::text('name', null, ['class' => 'form-control', 'required' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="id_number" class="filled">Cédula<span class="text-danger">*</span></label>
                                {{ Form::text('id_number', null, ['class' => 'form-control', 'required' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group form-group-style">
                                <label for="telephone" class="filled">Teléfono<span class="text-danger">*</span></label>
                                {{ Form::text('telephone', null, ['class' => 'form-control', 'required' => true]) }}
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" name="action" value="create" class="btn btn-cyan btn-lighten-2 btn-lg ld-ext-right">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    <button type="submit" name="action" value="createandsale" class="btn btn-cyan btn-lg ld-ext-right">Crear e iniciar venta
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    {{ Form::close() }}
                </div>

        </div>
    </div>
</div>
