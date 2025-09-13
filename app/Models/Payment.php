<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'client_id',
        'amount',
        'due_date',
        'payment_method',
        'transaction_id',
    ];

    // Relation with Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    // Relation with Client
    public function client()
    {
        return $this->belongsTo(Organization::class, 'client_id');
    }
}
