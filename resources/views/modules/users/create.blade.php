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
            <h3 class="content-header-title"><i class="icon-lock"></i> Usuarios</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Lista de usuarios</a></li>
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
                    <div class="card border-top-3 border-top-purple">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                {{ Form::open(['url' => '/usuarios', 'method' => 'post']) }}
                                    @include('modules.users.partials._form')
                                <div class="row pt-4">
                                    <div class="col-12 text-center">
                                        <a href="{{ route('users.list') }}" class="btn btn-grey btn-lg">
                                            <span class="fa fa-times"></span> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-purple  btn-lg">
                                            <span class="fa fa-check"></span> Guardar
                                        </button>
                                    </div>
                                </div>
                                {{ Form::close() }}
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
