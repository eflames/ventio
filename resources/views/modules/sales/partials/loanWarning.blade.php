<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 4/2/2019
 * Time: 6:03 PM
 */
?>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div id="errorBar" class="alert alert-icon-left alert-danger mb-2" role="alert">
            <span class="alert-icon"><i class="fa fa-warning"></i></span>
            <span class=""><strong>Este cliente tiene deudas pendientes por ${{ number_format($sale->client->activeLoans->sum('amount') - \App\Libraries\LoanUtils::getPayments($sale->client_id), 2) }}</strong></span>
        </div>
    </div>
</div>
