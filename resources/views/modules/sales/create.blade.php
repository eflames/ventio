<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/28/2019
 * Time: 1:29 AM
 */?>


@extends('layouts.ventioMaster')
@section('content')
    @include('modules.sales.newPaymentModal')
    @include('modules.sales.changePriceModal')
    @include('modules.sales.changePriceModalFull')
    <div class="sale-overlay"></div>
    @include('partials.alerts')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-detached content-left">
                <div class="content-body"><section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Agregar producto</h4>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('sale.additem') }}" class="AddItemForm" method="post" data-focus="stock_id">
                                        @csrf
                                        <div class="row">
                                            <div class="col-8">
                                                <fieldset class="form-group form-group-style">
                                                    <select class="select2-ajax-products-sale form-control" id="stock_id" name="stock_id" required onload="this.focus();"></select>
                                                </fieldset>
                                            </div>
                                            <div class="col-2">
                                                <fieldset class="form-group form-group-style">
                                                    {{ Form::text('qty', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Cant.']) }}
                                                </fieldset>
                                            </div>
                                            <div class="col-2">
                                                <button id="addbutton" type="submit" class="btn btn-success btn-lg addbutton">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale->id }}">
                                    </form>

                                    <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                        <span>Productos de esta venta</span>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-lg-12 col-md-12">
                                            <table class="table">
                                                <thead class="bg-blue-grey text-white">
                                                <tr>
                                                    <th class="text-center">Cantidad</th>
                                                    <th>Producto</th>
                                                    <th class="text-right">Subtotal</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody id="itemsTable">
                                                @include('modules.sales.partials.itemList')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="balance">
                                @include('modules.sales.partials.creditAvailable')
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Pagos</h4>
                                </div>
                                <div id="paymentItems">
                                    @include('modules.sales.partials.salePayments')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-right">
                <div class="sidebar">
                    <div class="project-sidebar-content">
                        <div id="salePrice">
                            @include('modules.sales.partials.saleTotal')
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">Cliente</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <dl>
                                        <dt>Nombre:</dt>
                                        <dd>
                                            <a href="{{ route('client.details', $sale->client->id_number) }}"
                                               data-tooltip="tooltip" data-placement="right" title="Detalles del cliente">
                                                {{ $sale->client->name }}
                                            </a>
                                        </dd>
                                        <dt>Cédula de Identidad</dt>
                                        <dd>{{ $sale->client->id_number }}</dd>
                                        <dt>Teléfono</dt>
                                        <dd>{{ $sale->client->telephone }}</dd>
                                        <dt>Dirección</dt>
                                        <dd>{{ $sale->client->address }}</dd>
                                        <dt>Comentario</dt>
                                        <dd>{{ $sale->client->comment }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        @can ('config', \App\User::class)
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title text-center">Almacen: <strong>{{ $default_warehouse->name }}</strong></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="btn-group btn-block">
                                        <button type="button" class="btn btn-light btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Cambiar almacén... </button>
                                        <div class="dropdown-menu">
                                            @foreach($warehouses as $warehouse)
                                                <a href="{{ route('sales.changeDefault', $warehouse->id) }}" class="dropdown-item">{{ $warehouse->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        
                        @include('modules.sales.procSaleModal')
                        <div id="procButtons">
                            @include('modules.sales.partials.procButtons')
                        </div>
                        <div class="card bg-grey bg-lighten-2">
                            <div class="card-header">
                                <h4 class="card-title text-center">Atajos de teclado</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p><strong><kbd>alt</kbd> + <kbd>p</kbd> &nbsp;&nbsp;&nbsp; Ventana de pagos</strong></p>
                                    <p><strong><kbd>alt</kbd> + <kbd>v</kbd> &nbsp;&nbsp;&nbsp; Procesar venta</strong></p>
                                    <p><strong><kbd>alt</kbd> + <kbd>c</kbd> &nbsp;&nbsp;&nbsp; Cancelar venta</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('after-styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-editable.css') }}">
    <style>
        .select2-dropdown{
            z-index: 998 !important;
        }
    </style>
@stop
@section('after-scripts')
    <script src="{{ asset('js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('js/saleAjaxFunctions.js') }}"></script>
    <script>
        $('#procSaleModal').css("margin-top", $(window).height() / 4 - 50);
        $('#changePriceModal').css("margin-top", $(window).height() / 4 - 100);
        $('#changePriceModalFull').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
        $('#newPaymentModal').css("margin-top", $(window).height() / 4 - 100);
        $('#changePriceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Cambiar precio para: <strong>' + button.data('item_name') + '</strong>');
            modal.find('#item_id').val(button.data('item_id'));
            modal.find('#item_price').val(button.data('item_price'));

        });
        $('#changePriceModalFull').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Cambiar precio para: <strong>' + button.data('item_name') + '</strong>');
            modal.find('#item_id').val(button.data('item_id'));
            modal.find('#item_price').val(button.data('item_price'));
        });

        function showBsField(){
            let paymentAmount = $('#amount_usd').val();
            let exchange_rate = {{ $config['exchange_rate'] }};
            let amount_bs = paymentAmount * exchange_rate;
            $('#amount_bs').val(amount_bs);
            $('#closedOptionBar').toggle();
            $('#openedOptionBar').toggle();
            $('#bsDiv').toggle();
        }

        function closeBsField(){
            $('#amount_bs').val('');
            $('#bsDiv').toggle();
            $('#closedOptionBar').toggle();
            $('#openedOptionBar').toggle();
        }

        function recalculateBsField(){
            let paymentAmount = $('#amount_usd').val();
            let exchange_rate = {{ $config['exchange_rate'] }};
            let amount_bs = paymentAmount * exchange_rate;
            $('#amount_bs').val(amount_bs);
        }
    </script>
@stop
