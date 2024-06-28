<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'price',
        'paid_amount',
        'total_price'
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
    use HasFactory;
}
