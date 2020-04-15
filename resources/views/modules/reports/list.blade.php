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
    @include('modules.reports.modal.byDateModal')
    @include('modules.reports.modal.byClientModal')
    @include('modules.reports.modal.byProductModal')
    @include('modules.reports.modal.byBsModal')
    @include('modules.reports.modal.byTypeModal')
    @include('modules.reports.modal.byExpensesModal')
    @include('modules.reports.modal.byProfitModal')
    @include('modules.reports.modal.byComissionModal')
    @include('modules.reports.modal.byReturnModal')
    @include('modules.reports.modal.byCategoryModal')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"> <i class="icon-pie-chart"></i> Reportes</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de reportes disponibles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-calendar font-large-3"></i></p>
                                <h2>
                                    Ventas por fecha
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byDateModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-user-following font-large-3"></i></p>
                                <h2>
                                    Ventas por cliente
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byClientModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-drawer font-large-3"></i></p>
                                <h2>
                                    Ventas por producto
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byProductModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-book-open font-large-3"></i></p>
                                <h2>
                                    Ventas por categoría
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byCategoryModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-credit-card font-large-3"></i></p>
                                <h2>
                                    Créditos por cobrar
                                </h2>
                                <p>
                                    <a href="{{ route('report.byCredit') }}" class="btn btn-indigo btn-lg">
                                        <span class="fa fa-check"></span> Generar
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-calculator font-large-3"></i></p>
                                <h2>
                                    Flujo de caja
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byTypeModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-arrow-down-circle font-large-3"></i></p>
                                <h2>
                                    Gastos
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byExpensesModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-arrow-up-circle font-large-3"></i></p>
                                <h2>
                                    Ganacias
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byProfitModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-wallet font-large-3"></i></p>
                                <h2>
                                    Generado en Bs.
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byBsModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-chart font-large-3"></i></p>
                                <h2>
                                    Comisiones
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byComissionModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-refresh font-large-3"></i></p>
                                <h2>
                                    Devoluciones
                                </h2>
                                <p>
                                    <button class="btn btn-indigo btn-lg" data-toggle="modal" data-target="#byReturnModal">
                                        <span class="fa fa-check"></span> Generar
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard text-center">
                                <p><i class="icon-share-alt font-large-3"></i></p>
                                <h2>
                                    Stock disponible
                                </h2>
                                <p>
                                    <a href="{{ route('report.byStock') }}" class="btn btn-indigo btn-lg">
                                        <span class="fa fa-check"></span> Generar
                                    </a>
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
    <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">
@stop
@section('after-scripts')
    <script src="{{ asset('js/switchery.min.js') }}"></script>
    <script>
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
        function toggleClient(){
            $('#byClientSelect').toggle()
        }
    </script>
@stop

