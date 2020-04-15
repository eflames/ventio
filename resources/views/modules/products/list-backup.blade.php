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
        <div class="content-header-left col-md-6 col-12 mb-2">
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
        @can('manageInventory', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
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
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-borderless datatable-spanish table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Identificador</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        @can('manageInventory', \App\User::class)
                                            <th class="text-center">Acciones</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ $product->identifier }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                                <td class="text-center">

                                                    {{ Form::open(['url' => 'productos/'.$product->id, 'method' => 'delete', 'id'=>'formelim-'.$product->id]) }}
                                                    <button type="button"
                                                            class="btn btn-grey-blue btn-sm" data-comment="{{ $product->description }}"
                                                            data-toggle="modal" data-target="#showCommentModal"
                                                            data-tooltip="tooltip" data-placement="left" title="ver descripción">
                                                        <span class="fa fa-exclamation-triangle"></span>
                                                    </button>
                                                    @can('manageInventory', \App\User::class)
                                                    <a href="{{route('products.edit', ['id' => $product->id]) }}" data-tooltip="tooltip"
                                                       data-placement="top" title="Editar" class="btn btn-blue btn-sm">
                                                        <span class="fa fa-pencil"></span>
                                                    </a>
                                                    <button type="button" onclick="alertElim('{{ $product->id }}')"
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
                                        <th>Identificador</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        @can('manageInventory', \App\User::class)
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
        $('#showCommentModal').css("margin-top", $(window).height() / 3 - $('.modal-content').height() / 3);
        $('#showCommentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#comment').html(button.data('comment'));
        })
    </script>
@stop
