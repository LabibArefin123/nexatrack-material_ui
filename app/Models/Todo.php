<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'category',
        'assigned_to'
    ];

    // Priority mapping
    public static $priorities = [
        1 => 'High',
        2 => 'Medium',
        3 => 'Low'
    ];

    // Status mapping
    public static $statuses = [
        1 => 'Pending',
        2 => 'Inprogress',
        3 => 'Completed',
        4 => 'Onhold'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getPriorityTextAttribute()
    {
        return self::$priorities[$this->priority] ?? 'N/A';
    }

    public function getStatusTextAttribute()
    {
        return self::$statuses[$this->status] ?? 'N/A';
    }
}
