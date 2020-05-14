<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.paymentMethods.newMethodModal')
@include('modules.paymentMethods.editMethodModal')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-settings"></i> Configuración</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Métodos de pago</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    <button type="button" class="btn btn-pink btn-lg" data-toggle="modal" data-target="#newMethodModal">
                        <span class="fa fa-plus"></span> Nuevo método
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
                                        <th class="text-center">Identificador</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($methods as $method)
                                            <tr>
                                                <td class="text-center">{{ $method->identifier }}</td>
                                                <td>{{ $method->name }}</td>
                                                <td>{{ $method->description }}</td>
                                                <td class="text-center">
                                                    {{ Form::open(['url' => 'metodos-de-pago/'.$method->id, 'method' => 'delete', 'id'=>'formelim-'.$method->id]) }}
                                                        <button type="button" data-name="{{ $method->name }}"
                                                                data-description="{{ $method->description }}"
                                                                data-payment_method_id="{{ $method->id }}"
                                                                data-identifier="{{ $method->identifier }}"
                                                                class="btn btn-blue btn-sm"
                                                                data-toggle="modal" data-target="#editMethodModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Editar">
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                        @if($method->id > 5)
                                                        <button type="button" onclick="alertElim('{{$method->id}}')"
                                                                class="btn btn-danger btn-sm"
                                                                data-tooltip="tooltip" data-placement="right" title="Eliminar">
                                                            <span class="fa fa-times"></span>
                                                        </button>
                                                        @endif
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
                                        <th class="text-center">Identificador</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
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
@stop
@section('after-scripts')
    <script>
        $('.modal-pay').css("margin-top", $(window).height() / 2 - ($('.modal-pay').height() / 2));
        $('#editMethodModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + '</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#identifier').val(button.data('identifier'));
            modal.find('#description').val(button.data('description'));
            modal.find('#payment_method_id').val(button.data('payment_method_id'));
        })
    </script>
@stop