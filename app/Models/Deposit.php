<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  client_id
 * @property  sale_id
 * @property  amount
 * @property string comment
 * @property int|null created_by
 * @property mixed client_id
 * @property mixed amount
 */
class Deposit extends Model
{
    protected $table = 'deposits';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
