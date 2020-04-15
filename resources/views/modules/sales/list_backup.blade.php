<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Ventas registradas</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Ventas registradas</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    <button type="button" class="btn btn-pink btn-lg" data-toggle="modal" data-target="#newMethodModal">
                        <span class="fa fa-plus"></span> Nueva venta
                    </button>
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
                            <h4 class="card-title">Ventas registradas</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th class="text-center"># Venta</th>
                                        <th>Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        {{--<th class="text-center">Artículos</th>--}}
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sales as $sale)
                                            <tr>
                                                <td class="text-center">{{ $sale->id }}</td>
                                                <td>{{ $sale->client->name }}</td>
                                                <td class="text-center">{{ $sale->created_at->format('d-m-Y') }}</td>
                                                {{--<td class="text-center">--}}
                                                    {{--<div class="badge @if( $sale->details->sum('qty') > 0)--}}
                                                            {{--badge-success @else badge-warning @endif">--}}
                                                        {{--<strong>{{ $sale->details->sum('qty') }}</strong>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
                                                <td class="text-right bg-light-green bg-lighten-5"><strong>${{ number_format($sale->details->sum('price'), 2) }}</strong></td>
                                                <td class="text-center @if( $sale->status->id === 1) bg-danger @else bg-green @endif bg-lighten-5">{{ $sale->status->name }}</td>
                                                <td class="text-center">
                                                    {{ Form::open(['url' => 'productos/'.$sale->id, 'method' => 'delete', 'id'=>'formelim-'.$sale->id]) }}
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-icon btn-sm btn-grey-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <button type="button" data-tooltip="tooltip" data-placement="left" title="Ver detalle" class="btn dropdown-item">
                                                                <span class="fa fa-search"></span> Ver detalle
                                                            </button>
                                                            @if( $sale->status->id === 1)
                                                                <button type="button" class="btn dropdown-item"
                                                                        data-tooltip="tooltip" data-placement="left" title="Editar">
                                                                    <span class="fa fa-pencil"></span> Editar
                                                                </button>
                                                                <div class="dropdown-divider"></div>
                                                                <button type="button"
                                                                        onclick="alertElim('{{ $sale->id }}')"
                                                                        class="btn dropdown-item"
                                                                        data-tooltip="tooltip" data-placement="left" title="Eliminar">
                                                                    <span class="fa fa-times"></span> Eliminar
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>

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
                                        <th class="text-center"># Venta</th>
                                        <th>Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        {{--<th class="text-center">Artículos</th>--}}
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Status</th>
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
@stop