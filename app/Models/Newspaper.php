<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newspaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'newspaper_code',
        'edition',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'newspaper_code';
    }

    public function customer(){
        return $this->hasMany(Customer::class, 'newspaper_code', 'newspaper_code');
    }
}
