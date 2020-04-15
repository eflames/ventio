<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null created_by
 */
class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = ['sale_id', 'client_id', 'payment_method_id', 'amount', 'comment'];

    public function method()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
