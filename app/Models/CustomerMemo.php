<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMemo extends Model
{
    protected $fillable = [
        'customer_id',
        'remarks',
        'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
