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
            <h3 class="content-header-title"><i class="icon-drawer"></i> Stock</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock.list') }}">Lista de stock disponible</a></li>
                        <li class="breadcrumb-item">Log de cambios en inventario</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-400 float-right">
                <div class="media-body media-right text-right">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        <a href="{{ route('stock.list') }}" class="btn btn-green btn-lg" data-tooltip="tooltip" data-placement="top" title="Regresar">
                            <span class="fa fa-arrow-left"></span> Regresar a la lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-green">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped datatable-spanish table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Usuario</th>
                                        <th class="text-center">Acción</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td class="text-center align-middle bg-grey bg-lighten-3"><strong>{{ $log->user->name }}</strong></td>
                                            <td class="text-center align-middle">{!! $log->message !!}</td>
                                            <td class="text-center align-middle bg-green bg-lighten-5"><strong>{{ $log->product ? $log->product->name : 'S/R' }}</strong></td>
                                            <td class="text-center align-middle"><strong>{{ $log->created_at->format('d/m/Y g:i a') }}</strong></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Usuario</th>
                                        <th class="text-center">Acción</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Fecha</th>
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