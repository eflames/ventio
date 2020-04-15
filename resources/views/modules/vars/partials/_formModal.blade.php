<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/15/2019
 * Time: 5:30 PM
 */?>
<div class="row mb-2">
    <div class="col-12 text-center">
        <span class="text-danger">*</span> son campos obligatorios
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Clave: <span class="text-danger">*</span></label>
            {{ Form::text('key', null, ['class' => 'form-control', 'required' => true, 'id' => 'key']) }}
            @if ($errors->has('key'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('key') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="description" class="filled">Valor: <span class="text-danger">*</span></label>
            {{ Form::textarea('value', null, ['class' => 'form-control', 'id' => 'value', 'rows' => '5']) }}
            @if ($errors->has('value'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('value') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="description" class="filled">Descripción:</label>
            {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'rows' => '5']) }}
            @if ($errors->has('description'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('description') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>