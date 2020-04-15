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
                            Generado en Bs.
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
                    {{ Form::open(['route' => 'report.byBsPdf', 'method' => 'post']) }}
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
                                <table class="table table-striped table-bordered table-borderless">
                                    <thead>
                                    <tr >
                                        <th>Venta</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php( $total = 0)
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td><strong>#{{ $payment->sale->id }}</strong></td>
                                                <td>{{ $payment->client->name }}</td>
                                                <td>{{ $payment->updated_at->format('d-m-Y') }}</td>
                                                <td class="text-right">Bs.{{ number_format($payment->amount_bs, 2, ',', '.') }}</td>
                                                @php( $total += $payment->amount_bs)
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                <strong>Total:</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>Bs.{{ number_format($total, 2, ',', '.') }}</strong>
                                            </td>
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

