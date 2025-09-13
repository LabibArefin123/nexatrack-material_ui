<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'responsibles',
        'start_date',
        'due_date',
        'tags',
        'priority',
        'status',
        'description',
    ];

    protected $casts = [
        'responsibles' => 'array',
        'tags' => 'array',
        'start_date' => 'date',
        'due_date' => 'date',
    ];
}
                               