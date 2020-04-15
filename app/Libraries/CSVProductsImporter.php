<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/14/2019
 * Time: 2:12 AM
 */

namespace App\Libraries;


use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CSVProductsImporter
{
    protected $msgRows = [];
    private $valids;

    /**
     * @return array
     */
    public function result(): array
    {
        return $this->msgRows;
    }

    private function checkCategoryExists($header, array $rows)
    {
        $cats = $this->getCategories($header, $rows);
        return ProductCategory::whereIn('id', $cats)->get()->pluck('id')->toArray();
    }

    private function checkExistsIdentifiers($header, $rows)
    {
        $ids = $this->getIdentifiers($header, $rows);
        return Product::whereIn('identifier', $ids)->get()->pluck('identifier')->toArray();
    }

    private function getCategories($header, array $rows): array
    {
        $categories = [];
        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            $categories[] = $row['product_category_id'];
        }
        return $categories;
    }
    private function getIdentifiers($header, array $rows): array
    {
        $idenfifiers = [];
        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            $idenfifiers[] = $row['identifier'];
        }
        return $idenfifiers;
    }

    private function getRowMessage($row, $param)
    {
        switch ($param) {
            case 'YES':
                $row['message'] = 'Producto agregado con éxito';
                $row['status'] = true;
                break;
            case 'EXIST':
                $row['message'] = 'Producto ya existe';
                $row['status'] = false;
                break;
            case 'NOCAT':
                $row['message'] = 'La categoría no existe';
                $row['status'] = false;
                break;
        }

        return $row;
    }

    private function processData($header, array $rows): void
    {
        $exists = $this->checkExistsIdentifiers($header, $rows);
        $validCat = $this->checkCategoryExists($header, $rows);

        foreach ($rows as $key => $row){
            $row = array_combine($header, $row);
            if (in_array($row['identifier'], $exists, false)) {
                $valid = 'EXIST';
            }elseif(!in_array($row['product_category_id'], $validCat, false)){
                $valid = 'NOCAT';
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
                Product::create([
                    'identifier' => $row['identifier'],
                    'name' => (string)$row['name'],
                    'product_category_id' => $row['product_category_id'],
                    'description' => (string)$row['description'],
                    'created_by' => Auth::user()->id,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::info('DB Commit Error: Products', [$e->getMessage()]);
            DB::rollBack();
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
            Log::info('importProducts error', [$e->getMessage()]);
            return false;
        }

    }

}
