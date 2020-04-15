<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.warehouses.newWareModal')
@include('modules.warehouses.editWareModal')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-settings"></i> Configuración</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Almacenes</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    <button type="button" class="btn btn-pink btn-lg" data-toggle="modal" data-target="#newWareModal">
                        <span class="fa fa-plus"></span> Nuevo almacén
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
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Predet.</th>
                                        <th class="text-center">Productos</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($warehouses as $warehouse)
                                            <tr>
                                                <td class="align-middle">{{ $warehouse->id }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('stock.filtered', ['slug' => $warehouse->slug]) }}">
                                                        {{ $warehouse->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $warehouse->description }}</td>
                                                <td class="text-center align-middle">
                                                    @if($warehouse->is_default == 1)
                                                        <a href="{{ route('warehouse.default',['id' => $warehouse->id, 'option' => 0]) }}"
                                                           class="btn btn-sm btn-light-green"
                                                           data-tooltip="tooltip" data-placement="left" title="Remover como predeterminado">
                                                            <span class="fa fa-check"></span>
                                                        </a>
                                                        @else
                                                        <a href="{{ route('warehouse.default',['id' => $warehouse->id, 'option' => 1]) }}"
                                                           class="btn btn-sm btn-grey"
                                                           data-tooltip="tooltip" data-placement="left" title="Marcar como predeterminado">
                                                            <span class="fa fa-times"></span>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="badge @if( $warehouse->products->count() > 0)
                                                            badge-success @else badge-warning @endif">
                                                        <a href="{{ route('stock.filtered', ['slug' => $warehouse->slug]) }}">
                                                            <strong>{{ $warehouse->products->count() }}</strong>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ Form::open(['url' => 'almacenes/'.$warehouse->id, 'method' => 'delete', 'id'=>'formelim-'.$warehouse->id]) }}
                                                        <button type="button" data-name="{{ $warehouse->name }}"
                                                                data-description="{{ $warehouse->description }}"
                                                                data-warehouse_id="{{ $warehouse->id }}"
                                                                class="btn btn-blue btn-sm"
                                                                data-toggle="modal" data-target="#editWareModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Editar">
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    <button type="button" onclick="alertElim('{{$warehouse->id}}')"
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
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Predet.</th>
                                        <th class="text-center">Productos</th>
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
        $('#editWareModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + '</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#warehouse_id').val(button.data('warehouse_id'));
        });
    </script>
@stop