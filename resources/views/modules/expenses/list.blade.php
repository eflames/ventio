<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 6/20/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.expenses.newExpenseModal')
@include('modules.expenses.editExpenseModal')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-credit-card"></i> Gastos</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Cuentas</li>
                        <li class="breadcrumb-item">Gastos</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('manageCredits', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <button type="button" class="btn btn-orange btn-lg" data-toggle="modal" data-target="#newExpenseModal">
                            <span class="fa fa-plus"></span> Nuevo gasto
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
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Cargado por:</th>
                                        <th class="text-right">Monto</th>
                                        @can('manageCredits', \App\User::class)
                                            <th class="text-center">Acciones</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($expenses as $expense)
                                            <tr>

                                                <td class="align-middle">{{ $expense->date ? date("d/m/Y", strtotime($expense->date)) : 'S/F'}}</td>
                                                <td class="align-middle">{{ $expense->description }}</td>
                                                <td class="align-middle">{{ $expense->createdBy->name }}</td>
                                                <td class="align-middle text-right bg-success bg-lighten-5"><strong>${{ number_format($expense->amount, 2) }}</strong></td>
                                                @can('manageCredits', \App\User::class)
                                                    <td class="text-center align-middle">
                                                        {{ Form::open(['url' => 'cuentas/gastos/'.$expense->id, 'method' => 'delete', 'id'=>'formelim-'.$expense->id]) }}
                                                            <button type="button" data-description="{{ $expense->description }}"
                                                                    data-amount="{{ $expense->amount }}"
                                                                    data-expense_id="{{ $expense->id }}"
                                                                    data-date="{{ $expense->date }}"
                                                                    class="btn btn-blue btn-sm"
                                                                    data-toggle="modal" data-target="#editExpenseModal"
                                                                    data-tooltip="tooltip" data-placement="left" title="Editar">
                                                                <span class="fa fa-pencil"></span>
                                                            </button>
                                                        <button type="button" onclick="alertElim('{{$expense->id}}')"
                                                                class="btn btn-danger btn-sm"
                                                                data-tooltip="tooltip" data-placement="right" title="Eliminar">
                                                            <span class="fa fa-times"></span>
                                                        </button>
                                                        {{ Form::close() }}
                                                    </td>
                                                @endcan
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"><h3>No hay resultados</h3></td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Cargado por:</th>
                                        <th class="text-right">Monto</th>
                                        @can('manageCredits', \App\User::class)
                                            <th class="text-center">Acciones</th>
                                        @endcan
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
        $('.expenses-modal').css("margin-top", $(window).height() / 5 - $('.modal-content').height() / 2);
        $('#editExpenseModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('description') + '</strong>');
            modal.find('#description').val(button.data('description'));
            modal.find('#amount').val(button.data('amount'));
            modal.find('#date').val(button.data('date'));
            modal.find('#expense_id').val(button.data('expense_id'));
        });
    </script>
@stop
