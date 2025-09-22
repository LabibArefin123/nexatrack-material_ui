<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'subject',
        'start_date',
        'end_date',
        'client_id',
        'type',
        'value',
        'attachment',
        'description',
    ];


    protected $casts = [
        'assigned_to' => 'array',
        'tags' => 'array',
        'date' => 'date:Y-m-d',
        'open_till' => 'date:Y-m-d',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    // App\Models\Contract.php
    public function getTypeNameAttribute()
    {
        $types = [
            'contracts_under_seal' => 'Contracts Under Seal',
            'implied_contracts'    => 'Implied Contracts',
            'executory_contracts'  => 'Executory Contracts',
            'voidable_contracts'   => 'Voidable Contracts',
        ];

        return $types[$this->type] ?? $this->type;
    }
}
