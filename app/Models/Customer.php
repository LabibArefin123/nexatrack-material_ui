<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'software',
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'area',
        'city',
        'country',
        'post_code',
        'note',
        'source',
        'is_read',
    ];

    public function memos()
    {
        return $this->hasMany(CustomerMemo::class, 'customer_id', 'id');
    }
}
