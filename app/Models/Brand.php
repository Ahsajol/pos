<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id';
    protected $fillable = [
        'brandname',
        'status'
    ];

    public function Products()
    {
        return $this->hasMany(Products::class, 'brand_id');
    }
    public function Sales()
    {
        return $this->hasMany(Sales::class, 'brand_id');
    }

    use HasFactory;
}
