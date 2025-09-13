<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanMemo extends Model
{
    protected $fillable = [
        'plan_id',
        'remarks',
        'date',
    ];

    public function plan()
    {
        return $this->belongsTo(Customer::class, 'plan_id', 'id');
    }
}
