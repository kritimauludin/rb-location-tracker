<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_code',
        'customer_name',
        'email',
        'phone_number',
        'join_date',
        'expire_date',
        'address',
        'latitude',
        'longitude'
    ];
}
