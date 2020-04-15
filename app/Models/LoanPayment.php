<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed load_id
 * @property mixed amount
 * @property int|null created_by
 * @property mixed loan_id
 * @property int closed
 */
class LoanPayment extends Model
{
    protected $table = 'loan_payments';

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
