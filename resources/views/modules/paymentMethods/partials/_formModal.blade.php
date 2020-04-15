<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/15/2019
 * Time: 5:43 PM
 */?>
<div class="row mb-2">
    <div class="col-12 text-center">
        <span class="text-danger">*</span> son campos obligatorios
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="identifier" class="filled">Identificador: <span class="text-danger">*</span></label>
            {{ Form::text('identifier', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Ej: Usd, $, Dólares', 'id' => 'identifier']) }}
            @if ($errors->has('identifier'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('identifier') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Nombre: <span class="text-danger">*</span></label>
            {{ Form::text('name', null, ['class' => 'form-control', 'required' => true, 'id' => 'name']) }}
            @if ($errors->has('name'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('name') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="description" class="filled">Descripción:</label>
            {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) }}
            @if ($errors->has('description'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('description') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
