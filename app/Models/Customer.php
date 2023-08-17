<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_code',
        'newspaper_code',
        'customer_name',
        'email',
        'phone_number',
        'join_date',
        'expire_date',
        'amount',
        'address',
        'latitude',
        'longitude'
    ];

    public function getRouteKeyName()
    {
        return 'customer_code';
    }

    public function user_distribution() {
        return $this->hasMany(UserDistribution::class, 'customer_code', 'customer_code');
    }

    public function newspaper(){
        return $this->belongsTo(Newspaper::class, 'newspaper_code', 'newspaper_code');
    }
}
