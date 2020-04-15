<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/8/2019
 * Time: 1:53 AM
 */?>

<div class="row">
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Nombre: <span class="text-danger">*</span></label>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('name') }}</small></p>
            @endif
        </fieldset>
    </div>
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="id_number" class="filled">Cédula de identidad: <span class="text-danger">*</span></label>
            {{ Form::number('id_number', null, ['class' => 'form-control']) }}
            @if ($errors->has('id_number'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('id_number') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="email" class="filled">Email:</label>
            {{ Form::email('email', null, ['class' => 'form-control']) }}
            @if ($errors->has('email'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('email') }}</small></p>
            @endif
        </fieldset>
    </div>
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="telephone" class="filled">Teléfono: <span class="text-danger">*</span></label>
            {{ Form::text('telephone', null, ['class' => 'form-control']) }}
            @if ($errors->has('telephone'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('telephone') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="address" class="filled">Dirección:</label>
            {{ Form::textarea('address', null, ['class' => 'form-control']) }}
            @if ($errors->has('address'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('address') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="comment" class="filled">Comentario</label>
            {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
            @if ($errors->has('comment'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('comment') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row pt-2">
    <div class="col-12 text-center">
        <span class="text-danger">*</span> son campos obligatorios
    </div>
</div>
<div class="row pt-3">
    <div class="col-12 text-center">
        <a href="{{ route('clients.list') }}" class="btn btn-grey btn-lg">
            <span class="fa fa-times"></span> Cancelar
        </a>
        <button type="submit" class="btn btn-cyan btn-lg ld-ext-right"><span class="fa fa-check"></span> Guardar
            <div class="ld ld-ring ld-spin"></div>
        </button>
    </div>
</div>

