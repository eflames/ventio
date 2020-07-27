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
@include('modules.products.importModal')
@include('modules.products.logModal')
@include('modules.products.showCommentModal')

    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-drawer"></i> Productos</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de productos</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <fieldset class="form-group position-relative has-icon-left">
                {{ Form::text('searchField', null, ['class' => 'form-control input-lg', 'id' => 'searchBar', 'placeholder' => 'Filtrar por identificador o nombre', 'id' => 'searchField', 'data-url' => route('api.getProducts')]) }}
                <div class="form-control-position">
                    <i class="icon-magnifier grey"></i>
                </div>
            </fieldset>
        </div>
        @can('manageInventory', \App\User::class)
            <div class="content-header-right col-md-4 col-12">
                <div class="media width-400 float-right">
                    <div class="media-body media-right text-right">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                            <a href="#" data-tooltip="tooltip" data-placement="left" title="Cargar en lote"
                               class="btn btn-light-green btn-lg"  data-toggle="modal" data-target="#importModal">
                                <span class="fa fa-upload"></span>
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-green btn-lg">
                                <span class="fa fa-plus"></span> Agregar producto
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
                    <div class="card border-top-3 border-top-green">
                        <div class="card-content collapse show">
                            <div id="loadSpinner" class="text-center"><span class="fa fa-spinner fa-spin fa-2x"></span></div>
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-bordered table-borderless">
                                    <thead>
                                    <tr>
                                        <th>Identificador</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id="recordsTable">
                                        @include('modules.products.partials.recordsTable')
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Identificador</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="float-right">
                                    {{ $products->render() }}
                                </div>
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
