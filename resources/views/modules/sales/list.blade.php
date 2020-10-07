<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('partials.alerts')

    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-basket-loaded"></i> Ventas registradas</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de ventas registradas</li>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <fieldset class="form-group position-relative has-icon-left">
                {{ Form::text('searchField', null, ['class' => 'form-control input-lg', 'id' => 'searchBar', 'placeholder' => 'ID, cliente, fecha(aaaa-mm-dd) o monto', 'id' => 'searchField', 'data-url' => route('sales.list')]) }}
                <div class="form-control-position">
                    <i class="icon-magnifier grey"></i>
                </div>
            </fieldset>
        </div>
        @can('sell', \App\User::class)
            <div class="content-header-right col-md-4 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        <button type="button" class="btn btn-grey-blue btn-lg" data-toggle="modal" data-target="#newSaleModal">
                            <span class="fa fa-plus"></span> Nueva venta
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
                    <div class="card border-top-3 border-top-grey-blue">
                        <div class="card-content">
                            <div id="loadSpinner" class="text-center"><span class="fa fa-spinner fa-spin fa-2x"></span></div>
                            <div class="card-body card-dashboard" id="recordsTable">
                                @include('modules.sales.partials.recordsTable')
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
<script type="text/javascript">
    $(function() {
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();

            $('#load a').css('color', '#dfecf6');
            $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

            var url = $(this).attr('href');
            getArticles(url);
            window.history.pushState("", "", url);
        });

        function getArticles(url) {
            $.ajax({
                url : url
            }).done(function (data) {
                $('#recordsTable').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        }
    });
</script>
@stop