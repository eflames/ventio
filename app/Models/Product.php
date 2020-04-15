<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'identifier', 'name', 'product_category_id', 'description', 'created_by'
    ];

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class,'product_id');
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function getIdentifierAttribute($value)
    {
        return strtoupper($value);
    }
}
