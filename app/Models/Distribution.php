<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_code',
        'courier_code',
        'user_code',
        'total'
    ];

    public function getRouteKeyName()
    {
        return 'distribution_code';
    }

    public function user_distibution() {
        return $this->belongsTo(UserDistribution::class);
    }
}
