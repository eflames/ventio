<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = ['description', 'amount'];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }
}
