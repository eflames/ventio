<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/7/2019
 * Time: 10:58 PM
 */ ?>

@extends('layouts.ventioMaster')
@section('content')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Productos</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.list') }}">Lista de productos</a></li>
                        <li class="breadcrumb-item">Crear nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-green">
                        {{ Form::open(['url' => '/productos', 'method' => 'post']) }}
                        <div class="card-header">
                            <h4 class="card-title">Crear nuevo producto <small><span class="text-danger">*</span> son campos obligatorios</small></h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <div class="pb-1">
                                        <input type="checkbox" class="js-switch" name="add_stock" value="1" @if (old('add_stock') == true) checked @endif  onchange="javascript:showStockFields()"/>
                                        <label for="is_default" class="font-medium-1 text-bold-400 ml-1"><strong>Agregar stock</strong></label>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                    @include('modules.products.partials._form')
                                </div>
                            </div>
                            {{ Form::close() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
@section('after-styles')
    <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">
@stop
@section('after-scripts')
    <script src="{{ asset('js/switchery.min.js') }}"></script>
    <script>
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
        function showStockFields(){
            $('#stockFields').toggle();
        }
    </script>
    
@stop