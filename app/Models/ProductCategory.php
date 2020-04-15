<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = ['name' , 'description'];

//    public function setCreatedByAttribute()
//    {
//        $this->attributes['created_by'] = Auth::user()->id;
//    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
