<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 6/20/2019
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
            <label for="name" class="filled">Descripción: <span class="text-danger">*</span></label>
            {{ Form::text('description', null, ['class' => 'form-control', 'required' => true, 'id' => 'description']) }}
            @if ($errors->has('description'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('description') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Monto: <span class="text-danger">*</span></label>
            {{ Form::number('amount', null, ['class' => 'form-control', 'required' => true, 'id' => 'amount', 'step' => 'any']) }}
            @if ($errors->has('amount'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('amount') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>