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
            <h3 class="content-header-title"><i class="icon-lock"></i> Roles</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Lista de usuarios</a></li>
                        <li class="breadcrumb-item">Lista de roles</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
        <div class="media width-250 float-right">
            <div class="media-body media-right text-right">
                <a href="{{ route('roles.create') }}" class="btn btn-purple btn-lg">
                    <span class="fa fa-plus"></span> Nuevo rol
                </a>
            </div>
        </div>
    </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-purple">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($roles as $rol)
                                        <tr>
                                            <td>{{ $rol->name }}</td>
                                            <td class="text-center">
                                                {{ Form::open(['url' => 'usuarios/permisos/'.$rol->id, 'method' => 'delete', 'id'=>'formelim-'.$rol->id]) }}
                                                <a href="{{route('roles.edit', $rol->id) }}" data-tooltip="tooltip"
                                                   data-placement="left" title="Editar" class="btn btn-blue btn-sm">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                                <button type="button" onclick="alertElim('{{$rol->id}}')"
                                                        class="btn btn-danger btn-sm"
                                                        data-tooltip="tooltip" data-placement="right" title="Eliminar">
                                                    <span class="fa fa-times"></span>
                                                </button>
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
