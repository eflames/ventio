<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/7/2019
 * Time: 10:58 PM
 */?>



@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')
    @include('modules.stock.importModal')
    @include('modules.stock.logModal')
    @include('modules.stock.editPriceModal')
    @include('modules.stock.addQtyModal')
    @include('modules.stock.transferQtyModal')
    @include('modules.stock.addStockModal')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-drawer"></i> Stock</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de stock disponible</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-400 float-right">
                <div class="media-body media-right text-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        @can('manageInventory', \App\User::class)
                            <a href="#" data-tooltip="tooltip" data-placement="left" title="Cargar en lote"
                               class="btn btn-light-green btn-lg"  data-toggle="modal" data-target="#importModal">
                                <span class="fa fa-upload"></span>
                            </a>
                            <a href="#" class="btn btn-green btn-lg" data-toggle="modal" data-target="#addStockModal">
                                <span class="fa fa-plus"></span> Agregar stock
                            </a>
                            <a href="{{ route('stock.log') }}" class="btn btn-green btn-lg btn-darken-2" data-tooltip="tooltip" data-placement="top" title="Log de cambios">
                                <span class="fa fa-list-alt"></span>
                            </a>
                        @endcan
                        @can('listInventory', \App\User::class)
                            <a href="{{ route('stock.report') }}" class="btn btn-green btn-lg btn-darken-3" data-tooltip="tooltip" data-placement="top" title="Descargar lista">
                                <span class="fa fa-download"></span>
                            </a>
                        @endcan
                        <button type="button" class="btn btn-green btn-darken-4 btn-icon dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                data-tooltip="tooltip" data-placement="top" title="Filtrar por almacén">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                            @foreach($wares as $warehouse)
                                <a class="dropdown-item" href="{{ route('stock.filtered', ['slug' => $warehouse->slug]) }}">
                                    {{ $warehouse->name }}
                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table id="datatable-spanish-stock-dt" class="table table-striped table-borderless table-success">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Disponible</th>
                                        <th class="text-center">Almacén</th>
                                        <th class="text-center">Precio venta</th>
                                        <th class="text-center">Precio costo</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>

                                        <th class="text-center">Disponible</th>
                                        <th class="text-center">Almacén</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Precio costo</th>
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
        $('#editPriceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#stock_id').val(button.data('stock_id'));
            modal.find('#price').val(button.data('price'));
            modal.find('#cost_price').val(button.data('cost_price'));
        });
        $('#addQtyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Añadir stock <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#stock_id').val(button.data('stock_id'));
            modal.find('#qty').val(button.data('qty'));
        });
        $('#transferQtyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Transferir stock <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
            modal.find('#stock_id').val(button.data('stock_id'));
            modal.find('#product_id').val(button.data('product_id'));
            modal.find('#fromWarehouse').val(button.data('warehouse'));
            modal.find('#warehousename').val(button.data('warehouse'));
            modal.find('#from_warehouse_id').val(button.data('from_warehouse_id'));
            modal.find('#qty').val(button.data('qty')).attr('max', button.data('qty'));
            modal.find('#name').val(button.data('name'));
            // modal.find('#quantity').attr('data-slider-max', button.data('qty'));
        });
    </script>
@stop