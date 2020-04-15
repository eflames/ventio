<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
    @include('modules.loans.showCommentModal')
    @include('modules.loans.addAmountModal')
    @include('modules.loans.newLoanModal')
    @include('modules.loans.newPaymentModal')
    {{--@include('modules.loans.logModal')--}}
    @include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-credit-card"></i> Por cobrar</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Cuentas</li>
                        <li class="breadcrumb-item">Por cobrar</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('manageCredits', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-400 float-right">
                    <div class="media-body media-right text-right">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                            <a href="#" class="btn btn-orange btn-lg btn-darken-2" data-toggle="modal" data-target="#newLoanModal">
                                <span class="fa fa-plus"></span> Agregar deuda manualmente
                            </a>
                            <a href="#" class="btn btn-orange btn-lg btn-darken-4" data-toggle="modal" data-target="#newPaymentModal">
                                <span class="fa fa-money"></span> Registrar pago
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-orange border-darken-3">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th class="text-center">Generado en</th>
                                        <th class="text-right">Restante</th>
                                        <th class="text-center">Progreso</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($credits as $credit)
                                        @php( $percentage = \App\Libraries\LoanUtils::loanPercentage($credit->amount, $credit->payments->sum('amount')) )
                                        <tr>
                                            <td class="align-middle bg-light-blue bg-lighten-5">
                                                <a href="{{ route('client.details', ['id' => $credit->client->id_number]) }}">
                                                    <strong>{{ $credit->client->name }}</strong>
                                                </a>
                                            </td>
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
                                                    ${{ number_format($credit->amount - $credit->payments->sum('amount'), 2) }}
                                                </strong>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="progress mb-0">
                                                    <div class="progress-bar @if($percentage >= 100) bg-success @else bg-warning @endif" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="{{ $percentage }}" aria-valuemax="100" style="width:{{ $percentage }}%" aria-describedby="Progreso de esta deuda"></div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">{{ $credit->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center align-middle">
                                                @include('modules.loans.partials.actionButtons')
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
                                        <th class="text-right">Monto</th>
                                        <th class="text-center">Progreso</th>
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
        $('#showCommentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#comment').html(button.data('comment'));
        });

        $('#addAmountModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#credit_id').val(button.data('credit_id'));
        });
        $(document).ready(function(){
            $('.logModalbtn').on('click',function(){
                var dataURL = $(this).attr('data-href');
                $('#logContent').load(dataURL,function(){
                    $('#logModal').modal({show:true});
                });
            });
        });
        function showAmount(){
            let client_id = $('#client_id').children("option:selected").val();
            $.ajax({
                type: "GET",
                url: '/api/cuentas/por-cobrar/' + client_id,
                cache: false,
                beforeSend:function(){
                    $('.sale-overlay').fadeIn();
                },
                success:function(data)
                {
                    $('#amountDiv').html(data);
                },
                error: function(data)
                {
                    $('#amountDiv').html(data.errors);
                }
            });
        }
    </script>
@stop