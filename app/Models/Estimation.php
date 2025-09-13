<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimation extends Model
{
    use HasFactory;

    protected $table = 'estimations';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'company_id',
        'user_id',
        'project_id',
        'bill_to',
        'ship_to',
        'amount',
        'currency',
        'estimate_date',
        'expiry_date',
        'status',
        'tags',
        'attachment',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'estimate_by' => 'array',
        'tags' => 'array',
        'estimate_date' => 'date',
        'expiry_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Relationships
     */

    public function company()
    {
        return $this->belongsTo(Organization::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
