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
                            Creditos por cobrar
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    {{ Form::open(['route' => 'report.byCreditPdf', 'method' => 'get']) }}
                    <button type="submit" class="btn btn-indigo btn-lg">
                        <span class="fa fa-file-pdf-o"></span> Descargar PDF
                    </button>
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
                                        <tr>
                                            <th>Cliente</th>
                                            <th class="text-right">Deuda total</th>
                                            <th class="text-right">Abonado</th>
                                            <th class="text-right">Restan</th>
                                        </tr>
                                        @php
                                            $LoansTotal = 0;
                                            $LoanPaymentsTotal = 0;
                                        @endphp
                                    </thead>
                                    <tbody>
                                    @foreach($clients as $client)
                                        @php
                                            $LoansTotal += $client->activeLoans->sum('amount');
                                            $LoanPaymentsTotal += \App\Libraries\LoanUtils::getPayments($client->id);
                                        @endphp
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                            <td class="text-right">${{ number_format($client->activeLoans->sum('amount'), 2) }}</td>
                                            <td class="text-right">${{ number_format(\App\Libraries\LoanUtils::getPayments($client->id), 2) }}</td>
                                            <td class="text-right">
                                                <strong>${{ number_format($client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($client->id), 2) }}</strong>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right">
                                                <strong>Totales:</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>${{ number_format($LoansTotal, 2) }}</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>${{ number_format($LoanPaymentsTotal, 2) }}</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>${{ number_format($LoansTotal - $LoanPaymentsTotal, 2) }}</strong>
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

