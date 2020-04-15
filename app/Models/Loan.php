<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null created_by
 * @property mixed amount
 * @property mixed sale_id
 * @property mixed client_id
 * @property string comment
 */
class Loan extends Model
{
    protected $table = 'loans';

    protected $fillable = ['client_id', 'amount', 'comment'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }
}
