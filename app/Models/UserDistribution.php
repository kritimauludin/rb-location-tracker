<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_code',
        'customer_code',
        'total',
        'recived_date',
        'status'
    ];

    public function distribution (){
        return $this->hasMany(Distribution::class);
    }

}