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
    .center{
        text-align: center;
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
    <div class="titulo">GANANCIAS:</div>
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
            <td colspan="5" class="subtitulo">Totales</td>
        </tr>
        <tr class="descripcion">
            <th class="center">Ventas totales</th>
            <th class="center">Precio de costo</th>
            <th class="center">Comisiones</th>
            <th class="center">Gastos</th>
            <th class="center">Ganancias</th>
        </tr>
        <tr class="datos">
            <th class="center">${{ number_format($earnings, 2) }}</th>
            <th class="center">${{ number_format($cost_price, 2) }}</th>
            <th class="center">${{ number_format($commissions, 2) }}</th>
            <th class="center">${{ number_format($expenses, 2) }}</th>
            <th class="center">${{ number_format($earnings - $cost_price - $commissions - $expenses, 2) }}</th>
        </tr>
    </table>
</section>
</body>

