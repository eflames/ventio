<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name', 'id_number', 'email', 'telephone', 'address', 'comment'
    ];

    public function buys()
    {
        return $this->hasMany(Sale::class);
    }

    public function balance()
    {
        return $this->hasMany(Deposit::class)->where('claimed');
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->where('closed', 0);
    }

    public function activeLoansPayments()
    {
        return $this->hasManyThrough(LoanPayment::class, Loan::class);
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

}