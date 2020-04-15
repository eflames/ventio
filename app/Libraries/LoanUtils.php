<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/21/2019
 * Time: 3:16 AM
 */

namespace App\Libraries;


use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Client;

class LoanUtils
{

    public static function loanPercentage($amount, $payments) : float{
        return round( ($payments * 100) / $amount, 1, PHP_ROUND_HALF_DOWN);
    }

    public static function getPayments($clientID)
    {
        $loanIDs = Loan::where('client_id', $clientID)->where('closed', 0)->pluck('id')->toArray();
        $payments = LoanPayment::whereIn('loan_id', $loanIDs)->get();
        return $payments->sum('amount');
    }

    public static function getClientLoansTotalButThisSale($clientId, $saleId)
    {
        $client = Client::findOrFail($clientId);
        $loans = $client->activeLoans->where('sale_id', '<>', $saleId);
        if($loans->count() > 0){
            $totalWOpayments = $loans->sum('amount');
            $loansIds = $loans->pluck('id');
            $loansPayments = LoanPayment::whereIn('loan_id', [$loansIds])->sum('amount');
            return $totalWOpayments - $loansPayments;
        }
        return 0;
    }


}