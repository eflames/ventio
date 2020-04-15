<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 6/28/2019
 * Time: 6:42 PM
 */?>

@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"> <i class="icon-pie-chart"></i> Reportes</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.list') }}">Lista de reportes disponibles</a></li>
                        <li class="breadcrumb-item">
                            Ganancias
                            desde <span class="red">{{ date('d-m-Y', strtotime($date_from)) }}</span>
                            hasta <span class="red">{{ date('d-m-Y', strtotime($date_to)) }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    {{ Form::open(['route' => 'report.byProfitPdf', 'method' => 'post']) }}
                    <button type="submit" class="btn btn-indigo btn-lg"
                            data-tooltip="tooltip"
                            data-placement="left" title="(SIN GRAFICOS)">
                        <span class="fa fa-file-pdf-o"></span> Descargar PDF
                    </button>
                    {{ Form::hidden('date_from', $date_from) }}
                    {{ Form::hidden('date_to', $date_to) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">

            <div class="row">
                <div class="col-7">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-12">
                                        <canvas id="pieChart" width="400" height="254" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card" style="margin-bottom: 0.8rem;">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-basket-loaded grey-blue warning font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>${{ number_format($earnings, 2) }}</h4>
                                        <h5 class="info">Ventas totales</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom: 0.8rem;">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-book-open grey-blue warning font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>${{ number_format($cost_price, 2) }}</h4>
                                        <h5 class="info">Precio de costo</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom: 0.8rem;">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-chart grey-blue warning font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>${{ number_format($commissions, 2) }}</h4>
                                        <h5 class="info">Comisiones</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom: 0.8rem;">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="icon-arrow-down-circle grey-blue warning font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>${{ number_format($expenses, 2) }}</h4>
                                        <h5 class="info">Gastos</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-success">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="ft-bar-chart white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h2 class="white">${{ number_format($earnings - $cost_price - $expenses - $commissions, 2) }}</h2>
                                        <h3 class="white">Ganancias</h3>
                                    </div>
                                </div>
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
    <script src="{{ asset('js/chart.min.js') }}"></script>

    <script>
        var ctx = $('#pieChart');
        var data = {
            datasets: [{
                data: [{{ round($cost_price, 2) }}, {{ round($expenses, 2) }}, {{ round($commissions, 2) }}, {{ round($earnings - $cost_price - $expenses - $commissions, 2) }}],
                backgroundColor: [
                    'rgba(197, 242, 255, 0.6)',
                    'rgba(255, 0, 5, 0.3)',
                    'rgba(174, 188, 55, 0.8)',
                    'rgba(55, 188, 155, 0.8)'
                ]
            }],
            
            labels: [
                'Precio de costo',
                'Gastos',
                'Comisiones',
                'Ganancias'
            ]
        };
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data
        });
    </script>
@stop

