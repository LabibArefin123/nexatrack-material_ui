<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'owner_id',
        'deal_id',
        'contract_id',
        'company_id',
        'title',
        'activity_type',
        'due_date',
        'time',
        'reminder',
        'description',
        'guests',
    ];

    protected $casts = [
        'due_date' => 'date',
        'time' => 'datetime:H:i',
        'guests' => 'array',
    ];

    // Relations
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function company()
    {
        return $this->belongsTo(Organization::class, 'company_id');
    }
}
