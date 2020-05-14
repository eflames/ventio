<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 18/1/19
 * Time: 11:36 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('partials.alerts')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">¡Bienvenido a Ventio!</h3>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card border-top-3 border-top-grey-blue">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title grey-blue mb-5 text-center">Acciones rápidas</h4>
                        <div class="form-group text-center mb-3">
                            <a href="{{ route('sales.list') }}" class="btn btn-float btn-cyan"><i class="fa fa-shopping-cart"></i><span>Listar ventas</span></a>
                            <a href="#" class="btn btn-float btn-float-lg btn-grey-blue" data-toggle="modal" data-target="#newSaleModal"><i class="fa fa-plus"></i><span>Nueva venta</span></a>
                            <button type="button" class="btn btn-float btn-cyan" data-toggle="modal" data-target="#newClientModal"><i class="fa fa-user-plus"></i><span>Nuevo cliente</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card mb-2 height-40-per">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h2 class="info">${{ number_format($salesToday->sum('amount'), 2) }}</h2>
                                <h5>Obtenidos en el día</h5>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-credit-card grey-blue font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card height-40-per" style="margin-top: 29px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h2 class="info">{{ $salesToday->count() }} ventas <small class="grey-blue">({{ $soldItems }}) artículos</small></h2>
                                <h5>Realizadas en el día</h5>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-shopping-cart grey-blue font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card mb-2 height-40-per">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h2 class="red">${{ number_format($loansTotal, 2) }}</h2>
                                <h5>En creditos por cobrar</h5>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-bar-chart grey-blue font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card height-40-per" style="margin-top: 29px;">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left">
                                <h2 class="cyan">${{ number_format($depositsTotal, 2) }}</h2>
                                <h5>En abonos no reclamados</h5>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-bar-chart-2 grey-blue font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Últimas ventas registradas</h4>
                </div>
                <div class="card-content">
                    <div class="container">
                        <table class="table table-hover table-borderless table-bordered">
                            <thead>
                            <tr>
                                <th>Venta</th>
                                <th>Cliente</th>
                                <th class="text-center">Artículos</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-right">Monto total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td class="text-truncate">
                                    <a href="{{ route('sale.view', ['id' => base64_encode($sale->id)]) }}">
                                        #{{ $sale->id }}
                                    </a>
                                </td>
                                <td class="text-truncate">
                                    <a href="{{ route('client.details', $sale->client->id_number) }}">
                                        <strong>{{ $sale->client->name }}</strong>
                                    </a>
                                </td>
                                <td class="text-truncate text-center">{{ $sale->details->sum('qty') }}</td>
                                <td class="text-truncate text-center">{{ $sale->updated_at->format('d/m/Y') }}</td>
                                <td class="text-truncate text-right">
                                    ${{ number_format($sale->details->sum('price'), 2) }}
                                </td>
                            </tr>
                                @empty
                                <tr>
                                    <td colspan="5"><h3>No hay ventas registradas aún</h3></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card card-inverse bg-info">
                <div class="card-content">
                    <div class="position-relative">
                        <div class="chart-title position-absolute mt-2 ml-2 white">
                            <h5 class="text-bold-200 white">Relación de ventas últimos meses</h5>
                        </div>
                        <canvas id="emp-satisfaction" class="height-400 block"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row">--}}
        {{--<div class="col-xl-12 col-lg-12">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">--}}
                    {{--<h4 class="card-title text-center">Movimiento de inventario</h4>--}}
                {{--</div>--}}
                {{--<div class="card-content">--}}
                    {{--<ul class="list-inline text-center pt-2 m-0">--}}
                        {{--<li class="mr-1">--}}
                            {{--<h6><i class="ft-circle grey-blue"></i> <span class="grey darken-1">Ingresos</span></h6>--}}
                        {{--</li>--}}
                        {{--<li class="mr-1">--}}
                            {{--<h6><i class="ft-circle pink"></i> <span class="grey darken-1">Egresos</span></h6>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<div class="chartjs height-250">--}}
                        {{--<canvas id="line-stacked-area" height="250"></canvas>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>


@stop
@section('after-styles')
@stop
@section('after-scripts')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        ! function(e, i, s) {
            "use strict";
            var a = s("#line-stacked-area"),
                t = (new Chart(a, {
                    type: "line",
                    options: {
                        responsive: !0,
                        maintainAspectRatio: !1,
                        pointDotStrokeWidth: 4,
                        legend: {
                            display: !1,
                            labels: {
                                fontColor: "#FFF",
                                boxWidth: 10
                            },
                            position: "top"
                        },
                        hover: {
                            mode: "label"
                        },
                        scales: {
                            xAxes: [{
                                display: !1
                            }],
                            yAxes: [{
                                display: !0,
                                gridLines: {
                                    color: "rgba(255,255,255, 0.3)",
                                    drawTicks: !1,
                                    drawBorder: !1
                                },
                                ticks: {
                                    display: !1,
                                    min: 0,
                                    max: 2,
                                    {{--max: {{ $maxInvChartData }},--}}
                                    maxTicksLimit: 4
                                }
                            }]
                        },
                        title: {
                            display: !1,
                            text: "Chart.js Line Chart - Legend"
                        }
                    },
                    data: {
                        labels: [1,2,3],
                        datasets: [{
                            label: "Articulos ingresados",
                            data: [1,2,3],
                            {{--data: @json($chartData[2]),--}}
                            backgroundColor: "transparent",
                            borderColor: "#1d4560",
                            borderWidth: 4,
                            pointColor: "#fff",
                            pointBorderColor: "#1d4560",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 4,
                            pointHoverBorderWidth: 4,
                            pointRadius: 5
                        }, {
                            label: "Artículos vendidos",
                            data: [1,2,3],
                            {{--data: @json($chartData[3]),--}}
                            backgroundColor: "transparent",
                            borderColor: "#E91E63",
                            borderDash: [5, 5],
                            borderWidth: 4,
                            pointColor: "#fff",
                            pointBorderColor: "#E91E63",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 4,
                            pointHoverBorderWidth: 4,
                            pointRadius: 5
                        }]
                    }
                }), i.getElementById("emp-satisfaction").getContext("2d")),
                r = t.createLinearGradient(0, 0, 0, 400);
            r.addColorStop(0, "rgba(255,255,255,0.5)"), r.addColorStop(1, "rgba(255,255,255,0)");
            new Chart(t, {
                type: "line",
                options: {
                    responsive: !0,
                    maintainAspectRatio: !1,
                    datasetStrokeWidth: 3,
                    pointDotStrokeWidth: 4,
                    tooltipFillColor: "rgba(0,0,0,0.8)",
                    legend: {
                        display: !1
                    },
                    hover: {
                        mode: "label"
                    },
                    scales: {
                        xAxes: [{
                            display: !1
                        }],
                        yAxes: [{
                            display: !1,
                            ticks: {
                                min: 0,
                                max: {{ $maxChartData }}
                            }
                        }]
                    },
                    title: {
                        display: !1,
                        fontColor: "#FFF",
                        fullWidth: !1,
                        fontSize: 40,
                        text: "82%"
                    }
                },
                data: {
                    labels: @json($chartData[0]),
                    datasets: [{
                        label: "Vendido ($)",
                        data: @json($chartData[1]),
                        backgroundColor: r,
                        borderColor: "rgba(255,255,255,1)",
                        borderWidth: 2,
                        strokeColor: "#FF6C23",
                        pointColor: "#fff",
                        pointBorderColor: "rgba(255,255,255,1)",
                        pointBackgroundColor: "#3BAFDA",
                        pointBorderWidth: 2,
                        pointHoverBorderWidth: 2,
                        pointRadius: 5
                    },]
                }
            });
        }(window, document, jQuery);
    </script>
@stop