<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.vars.newVarModal')
@include('modules.vars.editVarModal')
@include('partials.alerts')
@include('modules.vars.partials.licenseModal')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-settings"></i> Configuración <small>General</small></h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Configuración</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-450 float-right">
                <div class="media-body media-right text-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        <a href="{{ route('config.index') }}" class="btn btn-pink btn-lg" data-tooltip="tooltip" 
                        data-placement="left" title="Ir a configuración avanzada">
                            <span class="fa fa-cogs"></span> Configuración Avanzada
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-7">
                    <div class="card border-top-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                {{ Form::open(['route' => 'config.setStore', 'method' => 'post']) }}
                                <div class="row">
                                    <div class="col-12 mb-1"><h4>Tienda</h4></div>
                                </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <fieldset class="form-group form-group-style">
                                                <label class="filled">Nombre de la tienda: <span class="text-danger">*</span></label>
                                                {{ Form::text('store_name', $config['store_name'], ['class' => 'form-control', 'disabled' => true]) }}
                                            </fieldset>
                                        </div>
                                        <div class="col-6">
                                            <fieldset class="form-group form-group-style">
                                                <label class="filled">Correo electrónico de la tienda: <span class="text-danger">*</span></label>
                                                {{ Form::text('store_email', $config['store_email'], ['class' => 'form-control', 'required' => true]) }}
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-9">
                                            <p><span class="danger"><strong>Importante:</strong></span> El nombre de la tienda está definido por la licencia adquirida. No se puede editar manualmente.</p>
                                        </div>
                                        <div class="col-3 text-right">
                                            <button type="submit" class="btn btn-light btn-lg ld-ext-right">
                                                Actualizar <div class="ld ld-ring ld-spin"></div>
                                            </button>
                                        </div>
                                        
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card border-top-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                {{-- <div class="row">
                                    <div class="col-12"><h4>Información de la licencia</h4></div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Estado de la licencia:</strong> <span class="text-success">ACTIVA</span></p>
                                        <p><strong>Propietario:</strong> {{ $licenseOwner }}</p>
                                        <p><strong>Licencia válida hasta:</strong> {{ $licenseDate->format('d/m/Y') }}</p>
                                        <p><strong>Instalada el:</strong> {{ $license->created_at->format('d/m/Y') }}</p>
                                        <p><button class="btn btn-primary" data-toggle="modal" data-target="#licenseModal">Actualizar licencia</button></p>
                                    </div>
                                    <div class="col-6">
                                        <p><small><strong>Licencia:</strong> {{ $license->value }}</small></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card border-top-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                {{ Form::open(['route' => 'config.setImage', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                                    <p class="text-center"><img src="{{ asset('images/logo.png') }}" alt="Logo"></p>
                                    <p class="text-center">Cambia el logo del sistema para que aparezca en la barra superior y en todos los reportes.</p>
                                    <p class="text-center"><span class="text-info">IMPORTANTE:</span> Los formatos permitidos son <strong>JPG y PNG</strong></p>
                                    <p class="text-center">
                                        <label class="btn btn-primary" for="my-file-selector">
                                            <input id="my-file-selector" type="file" name="image" style="display:none;" onchange="$('#upload-file-info').html('¡Imagen seleccionada!');">
                                            Seleccionar archivo
                                        </label>
                                    </p>
                                    <div class="text-center">
                                        <span class='badge badge-success' id="upload-file-info"></span>
                                    </div>
                                    <p class="text-center">
                                        <button type="submit" class="btn btn-light btn-lg ld-ext-right">
                                            Enviar <div class="ld ld-ring ld-spin"></div>
                                        </button>
                                    </p>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <p class="text-center">
                                    <span class="fa fa-dollar fa-4x text-primary"></span>
                                </p>
                                <p class="text-center">Actualiza el valor del cambio en Bs del dia</p>
                                {{ Form::open(['route' => 'config.setVar', 'method' => 'post']) }}
                                <fieldset class="form-group form-group-style">
                                    <label class="filled">Valor: <span class="text-danger">*</span></label>
                                    {{ Form::number('value', $config['exchange_rate'], ['class' => 'form-control', 'required' => true, 'step' => '0.1']) }}
                                    {{ Form::hidden('option', 'exchange_rate') }}
                                </fieldset>
                                <p class="text-center">
                                    <button type="submit" class="btn btn-light btn-lg ld-ext-right">
                                        Actualizar <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </p>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <p class="text-center">
                                    <span class="fa fa-percent fa-4x text-primary"></span>
                                </p>
                                <p class="text-center">Porcentaje de comisión de los vendedores</p>
                                {{ Form::open(['route' => 'config.setVar', 'method' => 'post']) }}
                                <fieldset class="form-group form-group-style">
                                    <label class="filled">Porcentaje: <span class="text-danger">*</span></label>
                                    {{ Form::number('value', $config['commission_percentage'], ['class' => 'form-control', 'required' => true, 'step' => '0.1']) }}
                                    {{ Form::hidden('option', 'commission_percentage') }}
                                </fieldset>
                                <p class="text-center">
                                    <button type="submit" class="btn btn-light btn-lg ld-ext-right">
                                        Actualizar <div class="ld ld-ring ld-spin"></div>
                                    </button>
                                </p>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
@section('after-styles')
    <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">
@stop
@section('after-scripts')

    <script src="{{ asset('js/switchery.min.js') }}"></script>
    <script>
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    </script>
    <script>
        $('#editVarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('key') + '</strong>');
            modal.find('#key').val(button.data('key'));
            modal.find('#value').val(button.data('value'));
            modal.find('#description').val(button.data('description'));
            modal.find('#var_id').val(button.data('var_id'));
        });
        $('#licenseModal').css("margin-top", $(window).height() / 4 - ($('.modal-content').height() / 2));
    </script>
@stop