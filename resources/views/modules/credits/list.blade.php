<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
    @include('modules.credits.showCommentModal')
    @include('modules.credits.newCreditModal')
    @include('modules.credits.addAmountModal')
    @include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-credit-card"></i> Por pagar</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Cuentas</li>
                        <li class="breadcrumb-item">Por pagar</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('manageCredits', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <button type="button" class="btn btn-orange btn-lg" data-toggle="modal" data-target="#newCreditModal">
                            <span class="fa fa-plus"></span> Agregar
                        </button>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-orange">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-center">Reclamado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($credits as $credit)
                                        <tr>
                                            <td class="align-middle @if($credit->claimed) bg-grey bg-lighten-4 @else bg-light-blue bg-lighten-5 @endif">
                                                <a href="{{ route('client.details', $credit->client->id_number) }}">
                                                    <strong>{{ $credit->client->name }}</strong>
                                                </a>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($credit->sale_id === NULL)
                                                    <span class="blue">Manualmente</span>
                                                @else
                                                    <a href="{{ route('sale.view', base64_encode($credit->sale_id)) }}">
                                                        <strong>#{{ $credit->sale_id }}</strong>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                @if(!$credit->claimed)
                                                    <span class="success">Disponible</span>
                                                @else
                                                    @if($credit->claimed_in_sale_id)
                                                        <a href="{{ route('sale.view', ['id' => base64_encode($credit->claimed_in_sale_id)]) }}">
                                                            <strong>#{{ $credit->claimed_in_sale_id }}</strong>
                                                        </a>
                                                    @else
                                                        <span class="danger">Abonado manualmente</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="@if($credit->claimed === NULL) bg-green @else bg-grey @endif bg-lighten-5 text-right align-middle"><strong>${{ number_format($credit->amount, 2) }}</strong></td>
                                            <td class="text-center">{{ $credit->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center align-middle">
                                                {{ Form::open(['url' => 'cuentas/por-pagar/'.$credit->id, 'method' => 'delete', 'id'=>'formelim-'.$credit->id]) }}
                                                @if($credit->comment)
                                                    <button type="button"
                                                            class="btn btn-lighte btn-sm" data-comment="{{ $credit->comment }}"
                                                            data-toggle="modal" data-target="#showCommentModal"
                                                            data-tooltip="tooltip" data-placement="left" title="Ver comentario">
                                                        <span class="fa fa-eye"></span>
                                                    </button>
                                                @endif
                                                @can('manageCredits', \App\User::class)
                                                    @if(!$credit->claimed)
                                                        <button type="button" class="btn btn-success btn-sm"
                                                                data-tooltip="tooltip" data-placement="top" title="Registrar pago completo o parcial"
                                                                data-credit_id="{{ $credit->id }}"
                                                                data-comment="{{ $credit->comment }}"
                                                                data-toggle="modal" data-target="#addAmountModal">
                                                            <span class="fa fa-check-circle-o"></span> Pagar
                                                        </button>
                                                    @endif
                                                    <button type="button" onclick="alertElim('{{$credit->id}}')"
                                                            class="btn btn-danger btn-sm"
                                                            data-tooltip="tooltip" data-placement="right" title="Eliminar">
                                                        <span class="fa fa-times"></span>
                                                    </button>
                                                @endcan
                                                {{ Form::close() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"><h3>No hay resultados</h3></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Cliente</th>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-center">Reclamado en</th>
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Acciones</th>
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
    <script>
        $('#showCommentModal').css("margin-top", $(window).height() / 3 - $('.modal-content').height() / 3);
        $('#newCreditModal').css("margin-top", 100);
        $('#addAmountModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 5);
        $('#showCommentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#comment').html(button.data('comment'));
        });
        $('#addAmountModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#credit_id').val(button.data('credit_id'));
            modal.find('#comment').val(button.data('comment'));
        });
    </script>
@stop