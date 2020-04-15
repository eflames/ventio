<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')
    <div class="row">
        <div class="col-12">
            <h4 class="text-center">Registro de pagos</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Método de pago</th>
                    <th class="text-right">Abono</th>
                </tr>
                </thead>
                <tbody id="logContent">
                @forelse ($loan->payments as $payment)
                    <tr>
                        <td class="text-center align-middle">{{ $payment->created_at->format('d/m/Y') }}</td>
                        <td class="text-center align-middle">{{ $payment->payment_method_id ? $payment->method->name : 'Sin registro' }}</td>
                        <td class="text-right align-middle">${{ number_format($payment->amount, 2) }}
                            <a href="{{ route('loans.delPayment', $payment->id) }}"><span class="fa fa-remove danger"></span></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center"><strong>No hay registros aún para esta deuda</strong></td>
                    </tr>
                @endforelse
                <tr class="bg-success bg-lighten-5">
                    <td colspan="2" class="text-right align-middle"><strong>Total abonado</strong></td>
                    <td class="text-right align-middle font-medium-3">${{ number_format($loan->payments->sum('amount'), 2) }}</td>
                </tr>
                <tr class="bg-orange bg-lighten-5">
                    <td colspan="2" class="text-right align-middle"><strong>Restan</strong></td>
                    <td class="text-right align-middle font-medium-3">${{ number_format($loan->amount - $loan->payments->sum('amount'), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="align-middle text-center"> Del total deuda contraída por: <strong>${{ number_format($loan->amount, 2) }}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <a href="{{ route('loans.list') }}" class="btn btn-orange">
                <span class="fa fa-chevron-left"></span> Regresar
            </a>
        </div>
    </div>
@stop
