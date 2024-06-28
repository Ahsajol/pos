<?php

namespace App\Models;

use App\Models\Products;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'supplier_id',
        'customer_id',
        'paid_amount',
        'transaction_type',

    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }
    public function customers()
    {
        return $this->belongsTo(Customers::class);
    }
}
