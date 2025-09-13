<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deal_stage',
        'amount',
        'currency',
        'end_date',
        'client_option',
        'company_option',
        'deal_type',
        'source',
        'source_information',
        'start_date',
        'responsibles',
        'observer',
        'comment',
    ];

    protected $casts = [
        'responsibles' => 'array',
        'observer' => 'array',
    ];
}
