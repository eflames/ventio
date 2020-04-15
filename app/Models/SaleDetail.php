<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed sale_id
 * @property mixed qty
 * @property  double price
 * @property int|null created_by
 * @property mixed product_id
 */
class SaleDetail extends Model
{
    protected $table = 'sale_details';

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'id', 'stock_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function authorizedBy()
    {
        return $this->hasOne(User::class, 'id', 'authorized_by');
    }
}