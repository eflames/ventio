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
</style>
<body>
<section class="header">
    <img src="{{asset('images/logo.png')}}">
    <h1>REPORTE</h1>
    <div class="titulo">FLUJO DE CAJA:</div>
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
            <td colspan="2" class="subtitulo">Total recibido</td>
        </tr>
        <tr class="descripcion">
            <th>Método de pago</th>
            <th class="right">Total</th>
        </tr>
        @php( $total = 0)
        @foreach($payments as $payment)
            <tr class="datos">
                @if($payment->name == 'Deuda')
                    <td class="red"><strong>{{ $payment->name }}</strong> (método no reflejado en el total)</td>
                    <td class="red right">${{ number_format($payment->amount, 2) }}</td>
                @elseif($payment->name == 'Crédito')
                    <td class="red"><strong>{{ $payment->name }}</strong> (método no reflejado en el total)</td>
                    <td class="red right">${{ number_format($payment->amount, 2) }}</td>
                @else
                    <td><strong>{!! $payment->name !!}</strong></td>
                    <td class="right">${{ number_format($payment->amount, 2) }}</td>
                    @php( $total += $payment->amount)
                @endif
            </tr>
        @endforeach
        <tr class="descripcion">
            <th class="right">Total</th>
            <th class="right">${{ number_format($total, 2) }}</th>
        </tr>
    </table>
</section>
</body>

