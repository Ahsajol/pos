<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'stock_qty'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    use HasFactory;
}
