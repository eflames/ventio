<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 8/22/2019
 * Time: 7:52 PM
 */?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body{
        font-family: 'Open Sans', sans-serif;
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
        font-size: 20px;
        font-weight: bold;
    }
    .descripcion{
        background-color: #bdbdbd;
    }
    .right{
        text-align: right;
        padding-right: 5px;
    }
    .center{
        text-align: center;
        padding-right: 5px;
    }
    .datos {
        margin-top: 50px;
    }
    .red{
        color: red;
    }
</style>
<body>
<section class="header">
    <img src="{{asset('images/logo.png')}}">
    <h1>REPORTE</h1>
    <div class="titulo">STOCK DISPONIBLE</div>
    <br>
    Fecha de reporte: {{ date('d-m-Y') }}
</section>
<section class="datos">
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="4" class="subtitulo">Productos</td>
        </tr>
        <tr class="descripcion">
            <th>Nombre</th>
            <th class="center">Cantidad</th>
            <th class="center">Almacén</th>
            <th class="right">Precio</th>
        </tr>
        @foreach($details as $detail)
            <tr class="datos">
                <td>{{ $detail->product->name }}</td>
                <td class="center">{{ $detail->qty }}</td>
                <td class="center">{{ $detail->warehouse->name }}</td>
                <td class="right">${{ number_format($detail->price, 2) }}</td>
            </tr>
        @endforeach
    </table>
</section>
</body>