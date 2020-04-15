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
            <label for="email" class="filled">Email: <span class="text-danger">*</span></label>
            {{ Form::email('email', null, ['class' => 'form-control']) }}
            @if ($errors->has('email'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('email') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Contraseña: <span class="text-danger">*</span></label>
            {{ Form::password('password', ['class' => 'form-control']) }}
            @if ($errors->has('password'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('password') }}</small></p>
            @endif
        </fieldset>
    </div>
    <div class="col-6">
        <fieldset class="form-group form-group-style">
            <label for="email" class="filled">Confirmar contraseña: <span class="text-danger">*</span></label>
            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
            @if ($errors->has('password_confirmation'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('password_confirmation') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="selectOpt" class="filled">Rol de usuario: <span class="text-danger">*</span></label>
            {{ Form::select('rol_id', [''=>'Seleccione rol...'] + $userRoles->toArray(), null, ['class' => 'form-control', 'id' => 'selectOpt']) }}
            @if ($errors->has('rol_id'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('rol_id') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="col-12 text-center">
        <span class="text-danger">*</span> son campos obligatorios
    </div>
</div>
