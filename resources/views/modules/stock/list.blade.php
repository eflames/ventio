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
    @include('modules.stock.editMinStockModal')

    <div class="content-header row">
        <div class="content-header-left col-md-3 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-drawer"></i> Stock</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de stock disponible</li>
                        @if($almacen)
                            <li class="breadcrumb-item">Almacen <strong>{{ strtoupper($almacen) }}</strong></li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-12 mb-2">
            <fieldset class="form-group position-relative has-icon-left">
                {{ Form::text('searchField', null, ['class' => 'form-control input-lg', 'id' => 'searchBar', 'placeholder' => 'Filtrar por identificador y nombre', 'id' => 'searchField', 'data-url' => route('stock.list')]) }}
                {{ Form::hidden('almacen', @$almacen, ['id' => 'almacen']) }}
                <div class="form-control-position">
                    <i class="icon-magnifier grey"></i>
                </div>
            </fieldset>
            {{-- <fieldset class="form-group form-group-style" style="border: 2px solid rgb(222,222,222);background-color:#ffffff;">
                {{ Form::text('searchquery', null, ['class' => 'form-control', 'required' => true, 'id' => 'searchBar', 'placeholder' => 'Buscar por ID de venta o cliente...']) }}
                <div class="form-control-position">
                    <i class="fa fa-search grey"></i>
                </div>
            </fieldset> --}}
        </div>
        <div class="content-header-right col-md-5 col-12">
            <div class="media width-450 float-right">
                <div class="media-body media-right text-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        @can('manageInventory', \App\User::class)
                            <a href="#" data-tooltip="tooltip" data-placement="left" title="Cargar en lote"
                               class="btn btn-light-green btn-lg"  data-toggle="modal" data-target="#importModal">
                                <span class="fa fa-upload"></span>
                            </a>
                            <a href="#" class="btn btn-green btn-lg" data-toggle="modal" data-target="#addStockModal" data-tooltip="tooltip" data-placement="top" title="Agregar stock de productos">
                                <span class="fa fa-plus"></span> Stock
                            </a>
                            <a href="{{ route('products.createfs', 'fs') }}" class="btn btn-green btn-darken-2 btn-lg" data-tooltip="tooltip" data-placement="top" title="Agregar nuevo producto">
                                <span class="fa fa-plus"></span> Producto
                            </a>
                            <a href="{{ route('stock.listMinStock') }}" class="btn btn-danger btn-lg" data-tooltip="tooltip" data-placement="top" title="Mostrar items por debajo del stock mínimo">
                                <span class="fa fa-exclamation-circle"></span>
                            </a>
                            <a href="{{ route('stock.log') }}" class="btn btn-green btn-lg btn-darken-2" data-tooltip="tooltip" data-placement="top" title="Log de cambios">
                                <span class="fa fa-list-alt"></span>
                            </a>
                        @endcan
                        {{-- @can('listInventory', \App\User::class)
                            <a href="{{ route('stock.report') }}" class="btn btn-green btn-lg btn-darken-3" data-tooltip="tooltip" data-placement="top" title="Descargar lista">
                                <span class="fa fa-download"></span>
                            </a>
                        @endcan --}}
                        <button type="button" class="btn btn-green btn-darken-4 btn-icon dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                data-tooltip="tooltip" data-placement="top" title="Filtrar por almacén">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                             <a class="dropdown-item" href="{{ route('stock.list') }}">TODOS</a>
                            @foreach($wares as $warehouse)
                                <a class="dropdown-item" href="{{ route('stock.list', ['almacen' => $warehouse->slug]) }}">
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
                            <div id="loadSpinner" class="text-center"><span class="fa fa-spinner fa-spin fa-2x"></span></div>
                            <div class="card-body card-dashboard" id="recordsTable">
                                @include('modules.stock.partials.recordsTable')
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
<script type="text/javascript">

    $(function() {
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();

            $('#load a').css('color', '#dfecf6');
            $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

            var url = $(this).attr('href');
            getArticles(url);
            window.history.pushState("", "", url);
        });

        function getArticles(url) {
            $.ajax({
                url : url
            }).done(function (data) {
                $('#recordsTable').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        }
    });
</script>
@stop