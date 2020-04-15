<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed client_id
 * @property mixed created_by
 * @property int sale_status_id
 * @property mixed id
 */
class Sale extends Model
{
    protected $table = 'sales';

    protected $dates = ['closed_at'];

    public function client()
    {
        return $this->hasOne(Client::class, 'id','client_id');
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function status()
    {
        return $this->hasOne(SaleStatus::class, 'id','sale_status_id');
    }
}
