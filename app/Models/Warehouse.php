<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = ['name' , 'description'];

    public function products(){
        return $this->hasMany(Stock::class)->groupBy(['id','product_id']);
    }
}
