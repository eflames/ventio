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


    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-exclamation"></i> Stock Mínimo</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock.list') }}">Stock</a></li>
                        <li class="breadcrumb-item">Lista de mínimos superados</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-400 float-right">
                <div class="media-body media-right text-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                                <a href="{{ route('stock.list') }}" class="btn btn-green btn-lg"  data-tooltip="tooltip" data-placement="left" title="Regresar al stock">
                                    <span class="fa fa-arrow-left"></span> Regresar
                                </a>
                                <a href="{{ route('stock.generateMinStockPdf') }}" class="btn btn-green btn-lg btn-darken-2" data-tooltip="tooltip" data-placement="top" title="Descargar en PDF">
                                    <span class="fa fa-download"></span>
                                </a>
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
                                <table class="table table-striped datatable-spanish table-borderless">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Disponible | Mínimo</th>
                                        <th class="text-center">Almacén</th>
                                        <th class="text-center">Precio venta</th>
                                        <th class="text-center">Precio costo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($stock as $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $item->product->identifier }}</td>
                                            <td class="text-center align-middle text-bold-700">{{ strtoupper($item->product->name) }}</td>
                                            <td class="text-center align-middle">
                                                <div class="badge badge-md @if( $item->qty == 0) badge-danger @elseif($item->qty <= $item->min_stock) badge-warning @else badge-success @endif">
                                                    <strong>{{ $item->qty }} </strong>
                                                </div>
                                                | <div class="badge badge-md badge-secondary"> {{ $item->min_stock }}</div>
                                            </td>
                                            <td class="text-center align-middle">{{ $item->warehouse->name }}</td>
                                            <td class="text-center align-middle">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-center align-middle">${{ number_format($item->cost_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Identificador</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Disponible/Mínimo</th>
                                        <th class="text-center">Almacén</th>
                                        <th class="text-center">Precio venta</th>
                                        <th class="text-center">Precio costo</th>
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
@stop