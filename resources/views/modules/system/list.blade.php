<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/22/2019
 * Time: 6:42 PM
 */?>

@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"> <i class="icon-settings"></i> Configuración</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Sistema</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-4">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-credit-card font-large-3"></i></p>
                                <h2>
                                    Mantenimiento de cuentas
                                </h2>
                                <p>Realiza un mantenimiento de las cuentas, borra todas las cuentas por cobrar y por pagar que están cerradas.</p>
                                <p>
                                    {{ Form::open(['route' => 'config.maintenance', 'method' => 'post', 'id'=>'maintenance']) }}
                                        <button type="button" onclick="alertMaintenance()" class="btn btn-pink btn-lg" 
                                        data-tooltip="tooltip" data-placement="top" title="Realizar un borrado masivo de cuentas cerradas">
                                            <span class="fa fa-exclamation-triangle"></span> Mantenimiento de cuentas
                                        </button>
                                     {{ Form::close() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="fa fa-plug fa-4x"></i></p>
                                <h2>
                                    Conectores
                                </h2>
                                <p>Conecta una o más instalaciones de Ventio en otras locaciones y revisa de forma remota los movimientos</p>
                                <p>
                                    <a href="#" class="btn btn-pink btn-lg disabled">
                                        <span class="fa fa-plus" data-tooltip="tooltip" data-placement="top" title="..."></span> 
                                        Agregar conector
                                    </a>
                                    <a href="#" class="btn btn-pink btn-lg disabled" data-tooltip="tooltip" data-placement="top" title="...">
                                        Ver instalados
                                    </a>
                                </p>
                                <p class="danger text-center">No disponible con esta licencia</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-energy font-large-3"></i></p>
                                <h2>
                                    Backup de base de datos
                                </h2>
                                <p>Realiza un respaldo de la base de datos completo. Ten en cuenta que esta operación puede durar unos minutos.</p>
                                <p>
                                    <a href="{{ route('system.db') }}" class="btn btn-pink btn-lg ">
                                        <span class="fa fa-check"></span> Iniciar
                                    </a>
                                    <p class="danger text-center">No disponible con esta licencia</p>
                                </p>
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

