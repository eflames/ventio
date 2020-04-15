<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'p_sell',
        'p_sales',
        'p_s_inventory',
        'p_e_inventory',
        'p_s_clients',
        'p_e_clients',
        'p_s_credits',
        'p_e_credits',
        'p_discount',
        'p_reports',
        'p_users',
        'p_config'
    ];

    public function users(){
        return $this->hasMany(User::class,'rol_id');
    }

}
