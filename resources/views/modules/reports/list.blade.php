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
    @include('modules.reports.modal.byStockModal')
    @include('modules.reports.modal.byStockLogModal')
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
                <div class="col-12">
                    <h2 class="indigo">Reportes de venta</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byDateModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-calendar font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Ventas por fecha.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byClientModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-user-following font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Ventas por cliente.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byProductModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-drawer font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Ventas por producto.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byCategoryModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-book-open font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Ventas por categoría.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="indigo">Reportes financieros</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <a href="{{ route('report.byCredit') }}">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-credit-card font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Créditos por cobrar.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byTypeModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-calculator font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Flujo de caja.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byExpensesModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-arrow-down-circle font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Gastos.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byProfitModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-arrow-up-circle font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Ganacias.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byBsModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-wallet font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Generado en Bs.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byComissionModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-chart font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Comisiones.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="indigo">Reportes de stock</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byReturnModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-refresh font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Devoluciones.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byStockModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-share-alt font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Stock disponible.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#byStockLogModal">
                        <div class="card border-grey border-lighten-2">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard text-center">
                                    <div class="row align-items-center">
                                        <div class="col-3"><i class="icon-notebook font-large-3 grey darken-2 text-left"></i></div>
                                        <div class="col-9"><h2 class="text-left">Cambios en stock.</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
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
        $('.report-modal').css("margin-top", $(window).height() / 4 - ($('.modal-content').height() / 2));
        $('#byStockLogModal').css("margin-top", ($(window).height() - $('.modal-content').height()) / 5);
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
        function toggleClient(){
            $('#byClientSelect').toggle()
        }
    </script>
@stop

