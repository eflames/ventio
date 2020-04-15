<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/8/2019
 * Time: 1:53 AM
 */?>

<div class="row">
    <div class="col-12">
        <fieldset class="form-group form-group-style">
            <label for="name" class="filled">Nombre</label>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('name') }}</small></p>
            @endif
        </fieldset>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12"><h5>Permisos para el rol</h5></div>
</div>
<div class="row">
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="cyan">Módulo <strong>Ventas</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_sales" value="1" @if(@$rol->p_sales) checked @endif/>
                    <label for="p_sales" class="font-medium-1 text-bold-400 ml-1">Listar ventas</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_sell" value="1" @if(@$rol->p_sell) checked @endif/>
                    <label for="p_sell" class="font-medium-1 text-bold-400 ml-1">Vender</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="cyan">Módulo <strong>Inventario</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_s_inventory" value="1" @if(@$rol->p_s_inventory) checked @endif/>
                    <label for="p_s_inventory" class="font-medium-1 text-bold-400 ml-1">Listar</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_e_inventory" value="1" @if(@$rol->p_e_inventory) checked @endif/>
                    <label for="p_e_inventory" class="font-medium-1 text-bold-400 ml-1">Administrar</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="cyan">Módulo <strong>Clientes</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_s_clients" value="1" @if(@$rol->p_s_clients) checked @endif/>
                    <label for="p_s_clients" class="font-medium-1 text-bold-400 ml-1">Listar</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_e_clients" value="1" @if(@$rol->p_e_clients) checked @endif/>
                    <label for="p_e_clients" class="font-medium-1 text-bold-400 ml-1">Administrar</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="cyan">Módulo <strong>Cuentas</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_s_credits" value="1" @if(@$rol->p_s_credits) checked @endif/>
                    <label for="p_s_credits" class="font-medium-1 text-bold-400 ml-1">Listar</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_e_credits" value="1" @if(@$rol->p_e_credits) checked @endif/>
                    <label for="p_e_credits" class="font-medium-1 text-bold-400 ml-1">Adminsitrar</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="cyan"><strong>Sistema</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_discount" value="1" @if(@$rol->p_discount) checked @endif/>
                    <label for="p_discount" class="font-medium-1 text-bold-400 ml-1">Descuentos</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_reports" value="1" @if(@$rol->p_reports) checked @endif/>
                    <label for="p_reports" class="font-medium-1 text-bold-400 ml-1">Ver reportes</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_users" value="1" @if(@$rol->p_users) checked @endif/>
                    <label for="p_users" class="font-medium-1 text-bold-400 ml-1">Admin. usuarios</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group pb-1">
                    <input type="checkbox" class="js-switch" name="p_config" value="1" @if(@$rol->p_config) checked @endif/>
                    <label for="p_contig" class="font-medium-1 text-bold-400 ml-1">Admin. Configs</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-4">
    <div class="col-12 text-center">
        <a href="{{ route('roles.list') }}" class="btn btn-grey btn-lg">
            <span class="fa fa-times"></span> Cancelar
        </a>
        <button type="submit" class="btn btn-purple btn-lg">
            <span class="fa fa-check"></span> Guardar
        </button>
    </div>
</div>
