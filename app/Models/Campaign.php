<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'pipeline_id',
        'plan',
        'total_members',
        'sent',
        'opened',
        'delivered',
        'closed',
        'unsubscribe',
        'bounced',
        'progress',
        'status',
        'start_date',
        'end_date',
    ];

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }
}
