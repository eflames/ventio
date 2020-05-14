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
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title"><i class="icon-basket-loaded"></i> Ventas registradas</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item">Lista de ventas registradas</li>
                    </ol>
                </div>
            </div>
        </div>
        @can('sell', \App\User::class)
            <div class="content-header-right col-md-6 col-12">
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
                            <div class="card-body card-dashboard">
                                <table id="datatable-spanish-sales-dt" class="table table-striped table-bordered table-borderless">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Artículos</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Artículos</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Status</th>
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
$.fn.dataTable.pipeline = function ( opts ) {
    // Configuration options
    var conf = $.extend( {
        pages: 5,     // number of pages to cache
        url: '/ventas-dt/',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts );
 
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( typeof conf.data === 'function' ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            return $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );

$("#datatable-spanish-sales-dt").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        "ordering": false,
        ajax: $.fn.dataTable.pipeline( {
            url: '/ventas-dt/',
            pages: 5 // number of pages to cache
        } ),
        columns: [
            { data: 'id', name: 'id', className: 'align-middle'},
            { data: 'client', name: 'client', className: 'align-middle' },
            { data: 'closed_at', name: 'closed_at', className: 'align-middle' },
            { data: 'qty', name: 'qty', className: 'align-middle' },
            { data: 'amount', name: 'amount', className: 'align-middle' },
            { data: 'status', name: 'status', className: 'align-middle' },
            { data: 'actions', name: 'actions', className: 'align-middle' },
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No hay resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay resultados",
            infoFiltered: "(Filtrando de _MAX_ registros totales)",
            search: "Buscar:",
            processing: "Procesando data...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });


    </script>
@stop