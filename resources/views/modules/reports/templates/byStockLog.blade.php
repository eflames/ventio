<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/22/2019
 * Time: 7:09 PM
 */?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body{
        font-family: 'Open Sans', sans-serif;
        font-size: 13px;
    }
    .header, td, tr{
        text-align: center;
    }
    tr{
        height: 39px;
    }
    .titulo{
        color: #9b9b9b;
        font-size: 25px;
    }
    table {
        width: 100%;
    }
    .subtitulo{
        text-align: center;
        color: #000;
        vertical-align: middle;
        background-color: #f2f2f2;
        font-size: 17px;
        font-weight: bold;
    }
    .descripcion{
        background-color: #bdbdbd;
    }
    .right{
        text-align: right;
        padding-right: 5px;
    }
    .datos {
        margin-top: 50px;
    }
    .red{
        color: red;
    }
    .bold{
        font-weight: bold;
    }
</style>
<body>
<section class="header">
    <img src="{{asset('images/logo.png')}}">
    <h1>REPORTE</h1>
    <div class="titulo">CAMBIOS REALIZADOS</div>
    <div class="tienda">
        Desde <span class="red">{{ date('d-m-Y', strtotime($date_from)) }}</span>
        Hasta <span class="red">{{ date('d-m-Y', strtotime($date_to)) }}</span>
    </div>
    <br>
    Fecha de reporte: {{ date('d-m-Y') }}


</section>
<section class="datos">
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="4" class="subtitulo">Historial de cambios en stock</td>
        </tr>
        <tr class="descripcion">
            <th>Usuario</th>
            <th>Acción</th>
            <th>Producto</th>
            <th>Fecha</th>
        </tr>
        @forelse($logs as $log)
            <tr class="datos">
                <td><strong>{{ $log->user->name }}</strong></td>
                <td>{!! $log->message !!}</td>
                <td><strong>{{ $log->product ? $log->product->name : 'S/R' }}</strong></td>
                <td><strong>{{ $log->created_at->format('d/m/Y g:i a') }}</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="4"><h3>No hay resultados</h3></td>
            </tr>
        @endforelse
    </table>
</section>
</body>

