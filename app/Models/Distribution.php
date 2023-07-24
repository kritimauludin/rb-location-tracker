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
        'admin_code',
        'total_newspaper'
    ];

    public function getRouteKeyName()
    {
        return 'distribution_code';
    }

    public function user_distribution() {
        return $this->hasMany(UserDistribution::class, 'distribution_code', 'distribution_code');
    }

    public function courier(){
        return $this->belongsTo(User::class, 'courier_code', 'user_code');
    }
}
