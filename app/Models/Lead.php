<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'customer_id',
        'plan',
        'source',
        'status',
        'assigned_to',
        'note',
        'amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'Contacted',
            2 => 'Not Contacted',
            3 => 'Closed',
            4 => 'Lost',
            default => 'Unknown',
        };
    }
}
