<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_photo',
        'client',
        'priority',
        'start_date',
        'end_date',
        'pipeline_stage',
        'status',
    ];

    // App\Models\Project.php
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'client'); // client column = customer_id
    }
}
