<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="changeUserModal" role="dialog" aria-labelledby="changeUserModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{ Form::open(['route' => 'changeUser', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center pb-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Vent.IO">
                            <h3>Cambiar usuario</h3>
                        </div>
                    </div>
                    <fieldset class="form-group form-group-style">
                        <label for="email" class="filled">Correo electrónico: <span class="text-danger">*</span></label>
                        {{ Form::select('email', ['' => 'Seleccione usuario...'] + $usersLogin->toArray(), null, ['class' => 'form-control', 'required' => true]) }}
                        @if ($errors->has('email'))
                            <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('email') }}</small></p>
                        @endif
                    </fieldset>
                    <fieldset class="form-group form-group-style">
                        <label for="password" class="filled">Contraseña: <span class="text-danger">*</span></label>
                        {{ Form::password('password', ['class' => 'form-control' , 'required' => true]) }}
                        @if ($errors->has('password'))
                            <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('password') }}</small></p>
                        @endif
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn ld-ext-right btn-outline-info btn-block"><i class="ft-unlock"></i> Iniciar Sesión
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    <br>
                    <button type="button" class="btn btn-outline-grey btn-block" data-dismiss="modal">Cancelar</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
