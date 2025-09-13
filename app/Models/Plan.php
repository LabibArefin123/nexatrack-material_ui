<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'software',
        'source',
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'area',
        'city',
        'country',
        'post_code',
        'plan',
    ];
}
