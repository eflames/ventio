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
            <h3 class="content-header-title"><i class="icon-basket-loaded"></i> Ventas registradas</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de ventas registradas</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('sell', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <button type="button" class="btn btn-grey-blue btn-lg" data-toggle="modal" data-target="#newSaleModal">
                            <span class="fa fa-plus"></span> Nueva venta
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-grey-blue">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <table id="datatable-spanish-sales-dt" class="table table-striped table-bordered table-borderless">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Artículos</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Artículos</th>
                                        <th class="text-center">Monto</th>
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
    <script>

    </script>
@stop