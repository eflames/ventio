<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $table = 'stock_log';

    protected $fillable = ['product_id', 'message', 'created_by'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }

}
