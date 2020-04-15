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
            <h3 class="content-header-title"> <i class="icon-pie-chart"></i> Reportes</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.list') }}">Lista de reportes disponibles</a></li>
                        <li class="breadcrumb-item">
                            Flujo de caja
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
                    {{ Form::open(['route' => 'report.byTypePdf', 'method' => 'post']) }}
                    <button type="submit" class="btn btn-indigo btn-lg">
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
                <div class="col-12">
                    <div class="card border-top-3 border-top-indigo">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>Método de pago</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php( $total = 0)
                                    @forelse($payments as $payment)
                                        <tr>
                                            @if($payment->name == 'Deuda')
                                                <td class="text-danger"><strong>{{ $payment->name }} <small>(método no reflejado en el total)</small></strong></td>
                                                <td class="text-right text-bold-700 text-danger">${{ number_format($payment->amount, 2) }}</td>
                                            @elseif($payment->name == 'Crédito')
                                                <td class="text-danger"><strong>{{ $payment->name }} <small>(método no reflejado en el total)</small></strong></td>
                                                <td class="text-right text-bold-700 text-danger">${{ number_format($payment->amount, 2) }}</td>
                                            @elseif($payment->name == 'Abonos cuentas por cobrar')
                                                <td class="text-success"><strong>{{ $payment->name }}</strong></td>
                                                <td class="text-right text-bold-700 text-success">${{ number_format($payment->amount, 2) }}</td>
                                                @php( $total += $payment->amount)
                                            @else
                                                <td><strong>{!! $payment->name !!}</strong></td>
                                                <td class="text-right text-bold-700">${{ number_format($payment->amount, 2) }}</td>
                                                @php( $total += $payment->amount)
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">${{ number_format($total, 2) }}</th>
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

