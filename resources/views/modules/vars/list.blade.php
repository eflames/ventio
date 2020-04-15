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

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-settings"></i> Configuración</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Variables</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    <button type="button" class="btn btn-pink btn-lg" data-toggle="modal" data-target="#newVarModal">
                        <span class="fa fa-plus"></span> Nueva variable
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Clave</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vars as $var)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    {{ $var->key }}
                                                </td>
                                                <td class="align-middle text-center">{{ $var->description }}</td>
                                                <td class="align-middle text-center">{{ $var->value }}</td>
                                                <td class="text-center align-middle">
                                                    {{ Form::open(['url' => 'variables-de-configuracion/'.$var->id, 'method' => 'delete', 'id'=>'formelim-'.$var->id]) }}
                                                        <button type="button" data-key="{{ $var->key }}"
                                                                data-description="{{ $var->description }}"
                                                                data-value="{{ $var->value }}"
                                                                data-var_id="{{ $var->id }}"
                                                                class="btn btn-blue btn-sm"
                                                                data-toggle="modal" data-target="#editVarModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Editar">
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <button type="button" onclick="alertElim('{{$var->id}}')"
                                                            class="btn btn-danger btn-sm"
                                                            data-tooltip="tooltip" data-placement="right" title="Eliminar">
                                                        <span class="fa fa-times"></span>
                                                    </button>
                                                    {{ Form::close() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"><h3>No hay resultados</h3></td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
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
    </script>
@stop