<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/7/2019
 * Time: 10:58 PM
 */?>



@extends('layouts.ventioMaster')
@section('content')
    @include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-user-following"></i> Clientes</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de clientes</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('manageClients', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <a href="{{ route('clients.create') }}" class="btn btn-cyan btn-lg">
                            <span class="fa fa-plus"></span> Nuevo cliente
                        </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-cyan">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="text-center">Cédula</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">E-Mail</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($clients as $client)
                                        <tr>
                                            <td>
                                                <a href="{{ route('client.details', ['id' => $client->id_number]) }}"
                                                   data-tooltip="tooltip" data-placement="top" title="Ver detalles del cliente">
                                                    {{ $client->name }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $client->id_number }}</td>
                                            <td class="text-center">{{ $client->telephone }}</td>
                                            <td class="text-center">{{ $client->email }}</td>
                                            <td class="text-center">
                                                {{ Form::open(['url' => 'clientes/'.$client->id, 'method' => 'delete', 'id'=>'formelim-'.$client->id]) }}
                                                <a href="{{route('client.details', ['id' => $client->id_number]) }}" data-tooltip="tooltip"
                                                   data-placement="left" title="Ver detalles del cliente" class="btn btn-blue-grey btn-sm">
                                                    <span class="fa fa-search"></span>
                                                </a>
                                                @can('manageClients', \App\User::class)
                                                    @if($client->email)
                                                        @if(count($client->activeLoans) > 0)
                                                            <a href="{{route('client.notify', ['id' => $client->id]) }}" data-tooltip="tooltip"
                                                               data-placement="top" title="Enviar notificación de deuda" class="btn btn-orange btn-sm">
                                                                <span class="fa fa-envelope"></span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                    <a href="{{route('clients.edit', ['id' => $client->id]) }}" data-tooltip="tooltip"
                                                       data-placement="top" title="Editar" class="btn btn-blue btn-sm">
                                                        <span class="fa fa-pencil"></span>
                                                    </a>
                                                    <button type="button" onclick="alertElim('{{$client->id}}')"
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
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th>Teléfono</th>
                                        <th>E-Mail</th>
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

@stop
