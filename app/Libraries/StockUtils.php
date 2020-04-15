<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/12/2019
 * Time: 5:54 AM
 */

namespace App\Libraries;


use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class StockUtils
{
    public static function defaultStock($product_id)
    {
        $defaultWarehouse = Warehouse::where('is_default', 1)->pluck('id')->first();
        $stock = Stock::where('product_id', $product_id)->where('warehouse_id', $defaultWarehouse)->get();
        return $stock->sum('qty');
    }


    public static function updateStock($item, $restock = false){
        $stock = Stock::findOrFail($item->stock_id);
        if($restock == true){
            $stock->qty += $item->qty;
        }else{
            $stock->qty -= $item->qty;
        }
        $stock->save();
    }

    public static function log($product_id, $message){
        StockLog::create(['product_id' => $product_id, 'message' => $message, 'created_by' => Auth::id()]);
    }
}