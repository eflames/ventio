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
            <h3 class="content-header-title"><i class="icon-drawer"></i> Stock ({{ $filter }})</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock.list') }}">Stock</a></li>
                        <li class="breadcrumb-item">{{ $filter }}</li>
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
                        @endcan
                        @can('listInventory', \App\User::class)
                            <a href="{{ route('stock.reportFiltered', $filterSlug) }}" class="btn btn-green btn-lg btn-darken-2" data-tooltip="tooltip" data-placement="top" title="Descargar lista de {{ $filter }}">
                                <span class="fa fa-download"></span>
                            </a>
                        @endcan
                        <button type="button" class="btn btn-green btn-darken-3 btn-icon dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                data-tooltip="tooltip" data-placement="top" title="Filtrar por almacén">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="{{ route('stock.list') }}">
                                Todos
                            </a>
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
                        <div class="card-header">
                            <h4 class="card-title">Disponiblidad de productos en almacen: <strong>{{ $filter }}</strong></h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped datatable-spanish table-borderless table-success">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>
                                        {{--<th class="text-center">Categoría</th>--}}
                                        <th class="text-center">Disponible</th>
                                        {{--<th class="text-center">Almacén</th>--}}
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($stock as $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $item->product->identifier }}</td>
                                            <td class="text-center align-middle text-bold-700">{{ strtoupper($item->product->name) }}</td>
                                            {{--<td class="text-center align-middle">{{ $item->product->category->name }}</td>--}}
                                            <td class="text-center align-middle">
                                                <div class="badge @if( $item->qty > 0)
                                                        badge-success @else badge-warning @endif">
                                                    <strong>{{ $item->qty }}</strong>
                                                </div>
                                            </td>
                                            {{--<td class="text-center align-middlealign-middle">{{ strtoupper($item->warehouse->name) }}</td>--}}
                                            <td class="text-center align-middle">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-center align-middle">
                                                {{ Form::open(['url' => 'stock/'.$item->id, 'method' => 'delete', 'id'=>'formelim-'.$item->id]) }}
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-icon btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <button type="button"
                                                                data-name="{{ $item->product->name }}"
                                                                data-price="{{ $item->price }}"
                                                                data-warehouse="{{ strtoupper($item->warehouse->name) }}"
                                                                data-stock_id="{{ $item->id }}"
                                                                class="btn dropdown-item"
                                                                data-toggle="modal" data-target="#addQtyModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Añadir stock">
                                                            <span class="fa fa-plus-circle"></span> Añadir stock
                                                        </button>
                                                        <button type="button"
                                                                data-name="{{ $item->product->name }}"
                                                                data-stock_id="{{ $item->id }}"
                                                                data-warehouse="{{ strtoupper($item->warehouse->name) }}"
                                                                data-from_warehouse_id="{{ $item->warehouse->id}}"
                                                                data-qty="{{ $item->qty }}"
                                                                data-product_id="{{ $item->product->id }}"
                                                                class="btn dropdown-item"
                                                                data-toggle="modal" data-target="#transferQtyModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Transferir a otro almacén">
                                                            <span class="fa fa-exchange"></span> Transferir
                                                        </button>
                                                        <button type="button"
                                                                data-name="{{ $item->product->name }}"
                                                                data-price="{{ $item->price }}"
                                                                data-warehouse="{{ $item->warehouse->name }}"
                                                                data-stock_id="{{ $item->id }}"
                                                                class="btn dropdown-item"
                                                                data-toggle="modal" data-target="#editPriceModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Editar precio">
                                                            <span class="fa fa-dollar"></span> Editar precio
                                                        </button>
                                                        <div class="dropdown-divider"></div>
                                                        <button type="button"
                                                                onclick="alertElim('{{ $item->id }}')"
                                                                class="btn dropdown-item"
                                                                data-tooltip="tooltip" data-placement="left" title="Eliminar">
                                                            <span class="fa fa-times"></span> Eliminar
                                                        </button>
                                                    </div>
                                                </div>

                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>
                                        {{--<th class="text-center">Categoría</th>--}}
                                        <th class="text-center">Disponible</th>
                                        {{--<th class="text-center">Almacén</th>--}}
                                        <th class="text-center">Precio</th>
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
        $('#transferQtyModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height());
        $('#addStockModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
        $('#addQtyModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
        $('#editPriceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#stock_id').val(button.data('stock_id'));
            modal.find('#price').val(button.data('price'));
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