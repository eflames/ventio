<?php

namespace App;

use App\Models\Rol;
use App\Models\Sale;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'rol_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol(){
        return $this->hasOne(Rol::class,'id','rol_id');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'created_by', 'id');
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
}
