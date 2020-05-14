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
            <h3 class="content-header-title"><i class="icon-user-following"></i> Clientes</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de clientes</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('manageClients', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <a href="{{ route('clients.create') }}" class="btn btn-cyan btn-lg">
                            <span class="fa fa-plus"></span> Nuevo cliente
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-cyan">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table id="datatable-spanish-clients" class="table table-striped table-bordered table-borderless">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Cédula</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">E-Mail</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Cédula</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">E-Mail</th>
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
