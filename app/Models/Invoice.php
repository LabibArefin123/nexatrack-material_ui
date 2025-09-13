<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'client_id',
        'project_id',
        'user_id',
        'bill_to',
        'ship_to',
        'amount',
        'currency',
        'invoice_date',
        'due_date',
        'paid_amount',
        'payment_method',
        'status',
        'description',
        'items',
        'notes',
        'terms',
        'transaction_id',
    ];

    protected $casts = [
        'items' => 'array', // ✅ JSON auto cast
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(Organization::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
