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
    <div class="titulo">STOCK MÍNIMO</div>
    <br>
    Fecha de reporte: {{ date('d-m-Y') }}


</section>
<section class="datos">
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="5" class="subtitulo">Productos con stock mínimo superado</td>
        </tr>
        <tr class="descripcion">
            <th class="center">Identificador</th>
            <th class="center">Nombre</th>
            <th class="center">Disponible</th>
            <th class="center">Mínimo</th>
            <th class="center">Almacén</th>
        </tr>
        @foreach($items as $item)
            <tr class="datos">
                <td>{{ $item->product->identifier }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->qty }}</td>
                <td> {{ $item->min_stock }}</td>
                <td>{{ $item->warehouse->name }}</td>
            </tr>
        @endforeach
    </table>
</section>
</body>

