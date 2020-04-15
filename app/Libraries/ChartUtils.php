<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/29/2019
 * Time: 3:10 AM
 */

namespace App\Libraries;


use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use Illuminate\Support\Carbon;

class ChartUtils
{

    public function getChartData()
    {
        return $this->procData();
    }

    private function procData()
    {
        setlocale(LC_TIME, 'es_ES');
        Carbon::setLocale('es');
        $chartData = [];
        $chartData[0][] = Carbon::now()->startOfMonth()->subMonth(5)->format('F');
        $chartData[0][] = Carbon::now()->startOfMonth()->subMonth(4)->format('F');
        $chartData[0][] = Carbon::now()->startOfMonth()->subMonth(3)->format('F');
        $chartData[0][] = Carbon::now()->startOfMonth()->subMonth(2)->format('F');
        $chartData[0][] = Carbon::now()->startOfMonth()->subMonth()->format('F');
        $chartData[0][] = Carbon::now()->startOfMonth()->format('F');
        $chartData[1][] = Sale::where('sale_status_id', 2)->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(5)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(4)->subSeconds(1)->toDateTimeString()])->sum('amount');
        $chartData[1][] = Sale::where('sale_status_id', 2)->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(4)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(3)->subSeconds(1)->toDateTimeString()])->sum('amount');
        $chartData[1][] = Sale::where('sale_status_id', 2)->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(3)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(2)->subSeconds(1)->toDateTimeString()])->sum('amount');
        $chartData[1][] = Sale::where('sale_status_id', 2)->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(2)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth()->subSeconds(1)->toDateTimeString()])->sum('amount');
        $chartData[1][] = Sale::where('sale_status_id', 2)->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(), Carbon::now()->startOfMonth()->subSeconds(1)->toDateTimeString()])->sum('amount');
        $chartData[1][] = Sale::where('sale_status_id', 2)->where('updated_at', '>=', Carbon::now()->startOfMonth())->sum('amount');
//        $chartData[2][] = Stock::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(5)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(4)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[2][] = Stock::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(4)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(3)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[2][] = Stock::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(3)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(2)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[2][] = Stock::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(2)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth()->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[2][] = Stock::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(), Carbon::now()->startOfMonth()->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[2][] = Stock::where('updated_at', '>=', Carbon::now()->startOfMonth())->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(5)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(4)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(4)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(3)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(3)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth(2)->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(2)->toDateTimeString(), Carbon::now()->startOfMonth()->subMonth()->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(), Carbon::now()->startOfMonth()->subSeconds(1)->toDateTimeString()])->sum('qty');
//        $chartData[3][] = SaleDetail::whereHas('sale', function ($q){ $q->where('sale_status_id', 2); })->where('updated_at', '>=', Carbon::now()->startOfMonth())->sum('qty');
        $data['chartData'] = $chartData;
//        $maxloaded = max($chartData[2]);
//        $maxsold = max($chartData[3]);
        $data['maxChartData'] = max($chartData[1]) * 1.2;
//        $data['maxInvChartData'] = max([$maxloaded, $maxsold]) * 1.2;

        return $data;
    }
}