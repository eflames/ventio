<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/14/2019
 * Time: 2:12 AM
 */

namespace App\Libraries;


use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CSVStockImporter
{
    protected $msgRows = [];
    private $valids;
    private const PROD_IDENTIFIER = 'identifier';
    private const WARE_ID = 'warehouse_id';
    private const PRICE = 'price';
    private const COST_PRICE = 'cost_price';

    /**
     * @return array
     */
    public function result(): array
    {
        return $this->msgRows;
    }

    private function checkExistsIdentifiers($header, $rows)
    {
        $ids = $this->getIdentifiers($header, $rows);
        return Product::whereIn(self::PROD_IDENTIFIER, $ids)->get()->pluck(self::PROD_IDENTIFIER)->toArray();
    }

    private function checkWarehouseExists($header, array $rows)
    {
        $warehouses = $this->getWarehouses($header, $rows);
        return Warehouse::whereIn('id', $warehouses)->get()->pluck('id')->toArray();
    }

    private function getIdentifiers($header, array $rows): array
    {
        $idenfifiers = [];
        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            $idenfifiers[] = $row[self::PROD_IDENTIFIER];
        }
        return $idenfifiers;
    }

    private function getRowMessage($row, $param)
    {
        switch ($param) {
            case 'YES':
                $row['message'] = 'Stock agregado con éxito';
                $row['status'] = true;
                break;
            case 'NOPROD':
                $row['message'] = 'El producto no existe';
                $row['status'] = false;
                break;
            case 'NOWARE':
                $row['message'] = 'El almacén no existe';
                $row['status'] = false;
                break;
        }

        return $row;
    }

    private function getWarehouses($header, array $rows): array
    {
        $warehouses = [];
        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            $warehouses[] = $row[self::WARE_ID];
        }
        return $warehouses;
    }
    private function processData($header, array $rows): void
    {
        $exists = $this->checkExistsIdentifiers($header, $rows);
        $validWarehouse = $this->checkWarehouseExists($header, $rows);

        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            if (!in_array($row[self::PROD_IDENTIFIER], $exists, false)) {
                $valid = 'NOPROD';
            }elseif(!in_array($row['warehouse_id'], $validWarehouse, false)){
                $valid = 'NOWARE';
            }else{
                $valid = 'YES';
                $this->valids[] = $row;
            }
            $this->msgRows[$key] = $this->getRowMessage($row, $valid);
        }
        $this->saveData($this->valids);
    }

    private function saveData($rows): void {
        DB::beginTransaction();
        try {
            foreach ($rows as $row){
                $product = Product::where(self::PROD_IDENTIFIER, $row[self::PROD_IDENTIFIER])->pluck('id')->first();
                $check = Stock::where('product_id', $product)
                    ->where(self::WARE_ID, $row[self::WARE_ID])
                    ->where(self::COST_PRICE, $row[self::COST_PRICE])
                    ->where(self::PRICE, $row[self::PRICE])->first();
                if ($check){
                    $stock = $check;
                }else{
                    $stock = new Stock();
                    $stock->price = $row[self::PRICE];
                    $stock->cost_price = $row[self::COST_PRICE];
                    $stock->warehouse_id = $row[self::WARE_ID];
                    $stock->product_id = $product;
                }
                $stock->qty += $row['qty'];
                $stock->created_by = Auth::user()->id;
                $stock->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('DB Commit Error: Stock', [$e->getMessage()]);
        }
    }

    public function importProducts($csvfile): bool {
        try{
            $csvData = file_get_contents($csvfile);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            if(count(end($rows)) == 1){
                array_pop($rows);
            }
            $header = array_shift($rows);
            $this->processData($header, $rows);
            return true;
        }catch (\Exception $e){
            Log::info('importStock error', [$e->getMessage()]);
            return false;
        }
    }

}
