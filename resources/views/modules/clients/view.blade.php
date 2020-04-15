<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/28/2019
 * Time: 1:29 AM
 */?>
@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-user-following"></i> Clientes</strong>
            </h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients.list') }}">Clientes registrados</a></li>
                        <li class="breadcrumb-item">Detalle de <strong>{{ $client->name }}</strong>
                            @can('manageClients', \App\User::class)
                                <a href="{{route('clients.edit', ['id' => $client->id]) }}"> <span class="fa fa-pencil"></span> editar</a>
                            @endcan
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Cliente:</h4>
                                    <h4 class="grey">
                                        {{ $client->name }}
                                    </h4>
                                </div>
                                <div class="col-4 text-center">
                                    <h4>Cédula:</h4>
                                    <h4 class="grey">{{ $client->id_number }}</h4>
                                </div>
                                <div class="col-4 text-center">
                                    <h4>Teléfono:</h4>
                                    <h4 class="grey">{{ $client->telephone }}</h4>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-12">
                                    <h4>Dirección:</h4>
                                    <h4 class="grey">{{ @$client->address }}</h4>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-5">
                                    <h4>E-Mail:</h4>
                                    <h4 class="grey">{{ @$client->email }}</h4>
                                </div>
                                <div class="col-7">
                                    <h4>Comentario:</h4>
                                    <h5 class="grey">{{ @$client->comment }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card border-top-grey-blue border-top-3">
                    <div class="card-content">
                        <div class="card-header text-center">
                            <h3>Compras de este cliente</h3>
                        </div>
                        <div class="card-body">
                            <div class="project-search">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Vendedor</th>
                                        <th class="text-center">Artículos</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Detalle</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('sale.view', ['id' => base64_encode( $sale->id )]) }}">
                                                    <strong>#{{ $sale->id }}</strong>
                                                </a>
                                            </td>
                                            <td class="text-center align-middle">{{ $sale->updated_at->format('d/m/Y') }}</td>
                                            <td class="text-center align-middle">{{ $sale->seller->name }}</td>
                                            <td class="text-center align-middle">{{ $sale->details->sum('qty') }}</td>
                                            <td class="text-center align-middle">{{ $sale->status->name }}</td>
                                            <td class="text-right align-middle">${{ number_format($sale->amount, 2) }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('sale.view', ['id' => base64_encode($sale->id)]) }}" data-tooltip="tooltip" data-placement="left" class="btn btn-blue">
                                                    <span class="fa fa-search"></span> Ver detalles
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-6">
                <div class="card border-top-orange border-top-3">
                    <div class="card-content">
                        <div class="card-header text-center">
                            <h4>Cuentas por <strong>cobrar</strong> a este cliente</h4>
                        </div>
                        <div class="card-body">
                            <div class="project-search">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Abonado</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($credits as $credit)
                                        @php( $percentage = \App\Libraries\LoanUtils::loanPercentage($credit->amount, $credit->payments->sum('amount')) )
                                        <tr>
                                            <td class="text-center align-middle">
                                                @if($credit->sale_id == 0)
                                                    <strong>Manualmente</strong>
                                                @else
                                                    <a href="{{ route('sale.view', ['id' => base64_encode($credit->sale_id)]) }}">
                                                        <strong>#{{ $credit->sale_id }}</strong>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="@if($percentage >= 100) bg-grey @else bg-green @endif  bg-lighten-5 text-right align-middle">
                                                <strong>
                                                    ${{ number_format($credit->amount, 2) }}
                                                </strong>
                                            </td>
                                            <td class="text-center align-middle @if($credit->payments->sum('amount') == $credit->amount) bg-grey @else bg-danger  @endif bg-lighten-5">
                                                <strong>
                                                    ${{ number_format($credit->payments->sum('amount'), 2) }}
                                                </strong>                                                    </td>
                                            <td class="text-center align-middle">{{ $credit->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Abonado</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 @if($client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($client->id) > 0) bg-danger bg-lighten-4 @endif">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="project-search">
                                <h4 class="text-center">Deuda total:</h4>
                                <div class="text-center">
                                    <h2 class="">
                                        <strong>${{ number_format($client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($client->id), 2) }}</strong>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        @if(count($client->activeLoans) > 0)
                            @if($client->email === NULL)
                                <button data-tooltip="tooltip" data-placement="top"
                                        title="Agregar e-mail a este cliente para enviar notificación"
                                        class="btn btn-red btn-block btn-lg disabled">
                                    <span class="fa fa-ban"></span> Notificar deuda por correo
                                </button>
                            @else
                                <a href="{{route('client.notify', ['id' => $client->id]) }}" data-tooltip="tooltip"
                                   data-placement="top" title="Enviar notificación de deuda" class="btn btn-orange btn-block btn-lg">
                                    <span class="fa fa-envelope"></span> Notificar deuda por correo
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card border-top-orange border-top-3">
                    <div class="card-content">
                        <div class="card-header text-center">
                            <h4>Créditos <strong>a favor</strong> de este cliente</h4>
                        </div>
                        <div class="card-body">
                            <div class="project-search">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($deposits as $deposit)
                                        <tr>
                                            <td class="text-center align-middle">
                                                @if($deposit->sale_id === NULL)
                                                    <span class="blue">Manualmente</span>
                                                @else
                                                    <a href="{{ route('sale.view', ['id' => base64_encode($deposit->sale_id)]) }}">
                                                        <strong>#{{ $deposit->sale_id }}</strong>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="bg-green bg-lighten-5 text-right align-middle"><strong>${{ number_format($deposit->amount, 2) }}</strong></td>
                                            <td class="text-center">{{ $deposit->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 @if($deposits->sum('amount') > 0) bg-success bg-lighten-4 @endif">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="project-search">
                                <h4 class="text-center">A favor total:</h4>
                                <div class="text-center">
                                    <h2 class="">
                                        <strong>${{ number_format($deposits->sum('amount'), 2) }}</strong>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12 text-center">
                <a href="{{ route('clients.list') }}" class="btn btn-grey-blue btn-lg">
                    <span class="fa fa-arrow-left"></span> Regresar
                </a>
            </div>
        </section>
    </div>

@stop
@section('after-styles')

@stop
@section('after-scripts')

@stop
