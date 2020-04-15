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
    <div class="titulo">COMISIONES</div>
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
            <td colspan="3" class="subtitulo">Resultados</td>
        </tr>
        <tr class="descripcion">
            <th>Vendedor</th>
            <th class="right">Total vendido</th>
            <th class="right">Comisión ({{ $config['commission_percentage'] }}%)</th>
        </tr>
        @php( $total = 0)
        @foreach($users as $user)
            <tr>
                <td class="datos">{{ $user->name }}</td>
                <td class="right">${{ number_format($user->sales->sum('amount'), 2) }}</td>
                <td class="right"><strong>${{ number_format(($user->sales->sum('amount') * $config['commission_percentage']) / 100, 2) }}</strong></td>
                @php( $total += $user->sales->sum('amount'))
            </tr>
        @endforeach
        <tr>
            <td class="right">
                <strong>Totales:</strong>
            </td>
            <td class="right">
                <strong>${{ number_format($total, 2) }}</strong>
            </td>
            <td class="right">
                <strong>${{ number_format(($total * $config['commission_percentage']) / 100, 2) }}</strong>
            </td>
        </tr>
    </table>
</section>
</body>

