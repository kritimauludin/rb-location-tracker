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
        'process_at',
        'recived_at',
        'courier_last_stamp',
        'status'
    ];

    public function distribution (){
        return $this->belongsTo(Distribution::class, 'distribution_code', 'distribution_code');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_code', 'customer_code');
    }


}
