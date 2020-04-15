<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/22/2019
 * Time: 7:05 PM
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
    .header h3{
        color: #9b9b9b;
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
</style>
<body>
<section class="header">
    <img src="{{asset('images/logo.png')}}">
    <h1>REPORTE</h1>
    Pedidos por fecha
    <h1 class="tienda">
        Desde <span class="rojo">{{ date('d-m-Y', strtotime($fec_desde)) }}</span>
        Hasta <span class="rojo">{{ date('d-m-Y', strtotime($fec_hasta)) }}</span>
    </h1>
    Fecha de reporte: {{ date('d-m-Y') }}
</section>
<section class="datos">
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="7" class="subtitulo">Ventas realizadas</td>
        </tr>
        <tr class="descripcion">
            <th>id</th>
            <th>Tienda</th>
            <th>Fecha</th>
            <th>Descuento</th>
            <th>Cant. Líquidos</th>
            <th class="right">Subtotal</th>
            <th class="right">Total</th>
        </tr>
        @php $subtotal = 0; $total = 0; $cant = 0 @endphp
        @foreach($pedidos as $pedido)
            <tr class="datos">
                <td><strong>#{{ $pedido->id_usuario.'-'.$pedido->id }}</strong></td>
                <td>{{ $pedido->usuario->name }}</td>
                <td>{{ $pedido->updated_at->format('d-m-Y') }}</td>
                <td>@if( $pedido->descuento == 1 ) <span class="descuento">{{ $pedido->porcentaje }}%</span> @else N/A @endif</td>
                <td>{{ $pedido->detalle->sum('cantidad') }}</td>
                <td class="right">${{ number_format($pedido->subtotal, 2) }}</td>
                <td class="right">${{ number_format($pedido->total, 2) }}</td>
            </tr>
            @php $subtotal = $subtotal + $pedido->subtotal; $total = $total + $pedido->total; $cant = $cant + $pedido->detalle->sum('cantidad') @endphp
        @endforeach
        <tr class="descripcion">
            <td colspan="4" class="right">
                <strong>Totales:</strong>
            </td>
            <td>
                {{ $cant }}
            </td>
            <td class="right">
                <strong>${{ number_format($subtotal, 2) }}</strong>
            </td>
            <td class="right">
                <strong>${{ number_format($total, 2) }}</strong>
            </td>
        </tr>
    </table>
</section>
</body>
