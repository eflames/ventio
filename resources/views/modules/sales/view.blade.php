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
    @include('modules.sales.ReturnModal')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <h3 class="content-header-title">Detalle de venta #{{ $sale->id }}
                        @if( $sale->status->id === 1)
                            <a href="{{route('sale.edit', ['id' => base64_encode($sale->id)])}}"> <span class="fa fa-pencil"></span> editar</a>
                        @else
                            <span class="danger bold font-small-5">( venta cerrada |
                                @if($sale->closed_at)
                                    {{ date('d/m/Y', strtotime($sale->closed_at)) }}
                                @else
                                    {{ date('d/m/Y', strtotime($sale->updated_at)) }}
                                @endif
                            )</span>
                            {{--<span class="danger bold font-small-5">(venta cerrada | {{ $sale->closed_at->format('d/m/Y') }})</span>--}}
                        @endif
                    </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('sales.list') }}">Ventas registradas</a></li>
                                <li class="breadcrumb-item">#{{ $sale->id }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <h4>Cliente:</h4>
                                            <h4 class="grey">
                                                <a href="{{ route('client.details', $sale->client->id_number) }}"
                                                   data-tooltip="tooltip" data-placement="right" title="Ver detalles del cliente">
                                                    {{ $sale->client->name }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-4 text-center">
                                            <h4>Cédula:</h4>
                                            <h4 class="grey">{{ $sale->client->id_number ? : 'No hay datos' }}</h4>
                                        </div>
                                        <div class="col-4 text-center">
                                            <h4>Teléfono:</h4>
                                            <h4 class="grey">{{ $sale->client->telephone ? : 'No hay datos'  }}</h4>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-12">
                                            <h4>Dirección:</h4>
                                            <h4 class="grey">{{ @$sale->client->address ? : 'No hay datos'  }}</h4>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-5">
                                            <h4>E-Mail:</h4>
                                            <h4 class="grey">{{ @$sale->client->email ? : 'No hay datos'  }}</h4>
                                        </div>
                                        <div class="col-7">
                                            <h4>Comentario:</h4>
                                            <h5 class="grey">{{ @$sale->client->comment ? : 'No hay datos'  }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        @include('modules.sales.partials.saleTotal')
                        <div class="card mt-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="project-search">
                                        <p class="text-center">Vendedor:</p>
                                        <div class="text-center">
                                            <h2 class="">{{ $sale->seller->name }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">Productos de esta venta</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <table class="table table-hover">
                                            <thead class="bg-blue-grey text-white">
                                            <tr>
                                                <th class="text-center">Cantidad</th>
                                                <th>Producto</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($details as $detail)
                                                <tr>
                                                    <td class="text-center w-15 align-middle">
                                                        {{ $detail->qty }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <strong>{{ $detail->product->name }}</strong>
                                                        @if($detail->returned <> 1)
                                                            <button type="button" class="btn btn-sm btn-light"
                                                                    data-toggle="modal" data-tooltip="tooltip"
                                                                    data-placement="right" title="Devolver item"
                                                                    data-target="#returnModal" data-detail_id="{{ $detail->id }}"
                                                                    data-name="{{ $detail->product->name }}">
                                                                <span class="fa fa-refresh green"></span> Devolver
                                                            </button>
                                                        @else
                                                            <small class="red">Devuelto</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-right align-middle">
                                                        @if($detail->authorized_by)
                                                            <span class="warning fa fa-warning"
                                                                  data-tooltip="tooltip" data-placement="left" title="Precio cambiado por {{ $detail->authorizedBy->name }}">
                                                            </span>
                                                        @endif
                                                        @if($detail->gift)
                                                            <span class="pink"><small>¡REGALO!</small></span>
                                                        @else
                                                            <strong>${{ number_format($detail->price,2) }}</strong>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">No hay artículos agregados en esta venta aún.</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">Pagos</h4>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr class="bg-success white">
                                        <th class="text-center">Fecha</th>
                                        <th>Método</th>
                                        <th class="text-center">Commentario</th>
                                        <th class="text-right">Monto</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sale->payments as $payment)
                                        <tr>
                                            <td class="text-center">{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td><strong>{{ $payment->method->name }}</strong></td>
                                            <td class="text-right">{{ $payment->comment }}</td>
                                            <td class="text-right">${{ number_format($payment->amount,2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total pagado:</strong></td>
                                        <td class="text-right"><strong>${{ number_format($sale->payments->sum('amount'), 2) }}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                @if($sale->comment)
                    <section class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Comentario</h4>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-center">{{ $sale->comment }}</h3>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                <section class="row">
                    <div class="col-12 text-center">
                        <a href="{{ route('sales.list') }}" class="btn btn-grey-blue btn-lg">
                            <span class="fa fa-arrow-left"></span> Regresar
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>

@stop
@section('after-styles')
    <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">
@stop
@section('after-scripts')
    <script src="{{ asset('js/switchery.min.js') }}"></script>
    <script>
        $('#returnModal').css("margin-top", $(window).height() / 4 - 100);
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
        $('#returnModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Devolver <strong>' + button.data('name') + '</strong>');
            modal.find('#detail_id').val(button.data('detail_id'));
        });
    </script>
@stop
