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
    <div class="titulo">VENTAS POR CATEGORÍA:</div>
    <strong>{{ $category_name }}</strong>
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
            <td colspan="4" class="subtitulo">Productos vendidos</td>
        </tr>
        <tr class="descripcion">
            <th>Identificador</th>
            <th>Producto</th>
            <th>Vendidos</th>
            <th class="right">Monto</th>
        </tr>
        @php
            $totalQty = 0;
            $totalPrice = 0;
        @endphp
        @foreach($sales as $detail)
            @php
                $totalQty += $detail->sold;
                $totalPrice += $detail->money;
            @endphp
            <tr class="datos">
                <td><strong>{{ $detail->identifier }}</strong></td>
                <td>{{ $detail->name }}</td>
                <td>{{ $detail->sold }}</td>
                <td class="right">${{ number_format($detail->money, 2) }}</td>
            </tr>
        @endforeach
        <tr class="descripcion">
            <td colspan="2" class="right">
                <strong>Totales:</strong>
            </td>
            <td>
                {{ $totalQty }}
            </td>
            <td class="right">
                <strong>${{ number_format($totalPrice, 2) }}</strong>
            </td>
        </tr>
    </table>
</section>
</body>

