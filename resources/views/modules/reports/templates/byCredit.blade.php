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
    .bold{
        font-weight: bold;
    }
</style>
<body>
<section class="header">
    <img src="{{asset('images/logo.png')}}">
    <h1>REPORTE</h1>
    <div class="titulo">CRÉDITOS POR COBRAR</div>
    <br>
    Fecha de reporte: {{ date('d-m-Y') }}


</section>
<section class="datos">
    <table border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="4" class="subtitulo">Créditos otorgados</td>
        </tr>
        <tr class="descripcion">
            <th>Cliente</th>
            <th class="right">Deuda total</th>
            <th class="right">Abonado</th>
            <th class="right">Restan</th>
        </tr>
        @php
        $LoansTotal = 0;
        $LoanPaymentsTotal = 0;
        @endphp
        @foreach($clients as $client)
            @php
                $LoansTotal += $client->activeLoans->sum('amount');
                $LoanPaymentsTotal += \App\Libraries\LoanUtils::getPayments($client->id);
            @endphp
            <tr class="datos">
                <td>{{ $client->name }}</td>
                <td class="right">${{ number_format($client->activeLoans->sum('amount'), 2) }}</td>
                <td class="right">${{ number_format(\App\Libraries\LoanUtils::getPayments($client->id), 2) }}</td>
                <td class="right">
                    <strong>${{ number_format($client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($client->id), 2) }}</strong>
                </td>

            </tr>
        @endforeach
        <tr class="descripcion">
            <td class="right">
                <strong>Totales:</strong>
            </td>
            <td class="right bold">
                ${{ number_format($LoansTotal, 2) }}
            </td>
            <td class="right bold">
                <strong>${{ number_format($LoanPaymentsTotal, 2) }}</strong>
            </td>
            <td class="right bold">
                <strong>${{ number_format($LoansTotal - $LoanPaymentsTotal, 2) }}</strong>
            </td>
        </tr>
    </table>
</section>
</body>

