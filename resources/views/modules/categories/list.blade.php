<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.categories.newCatModal')
@include('modules.categories.editCatModal')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-settings"></i> Configuración</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Categorías de producto</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="media width-250 float-right">
                <div class="media-body media-right text-right">
                    <button type="button" class="btn btn-pink btn-lg" data-toggle="modal" data-target="#newCatModal">
                        <span class="fa fa-plus"></span> Nueva categoría
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-striped table-borderless table-bordered datatable-spanish">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Productos</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td class="text-center">
                                                    <div class="badge @if( $category->products->count() > 0)
                                                            badge-success @else badge-warning @endif">
                                                        {{ $category->products->count() }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ Form::open(['url' => 'categorias/'.$category->id, 'method' => 'delete', 'id'=>'formelim-'.$category->id]) }}
                                                        <button type="button" data-name="{{ $category->name }}"
                                                                data-description="{{ $category->description }}"
                                                                data-category_id="{{ $category->id }}"
                                                                class="btn btn-blue btn-sm"
                                                                data-toggle="modal" data-target="#editCatModal"
                                                                data-tooltip="tooltip" data-placement="left" title="Editar">
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                        <button type="button" onclick="alertElim('{{$category->id}}')"
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
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Productos</th>
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
        $('#editCatModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + '</strong>');
            modal.find('#name').val(button.data('name'));
            modal.find('#description').val(button.data('description'));
            modal.find('#category_id').val(button.data('category_id'));
        })
    </script>
@stop