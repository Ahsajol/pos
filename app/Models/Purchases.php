<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{

    protected $table = 'purchase';
    protected $primaryKey = 'id';
    protected $fillable = [
        'supplier_id',
        'product_id',
        'quantity',
        'price',
        'total_price'
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
    use HasFactory;
}
