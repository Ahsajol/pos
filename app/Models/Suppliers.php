<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'suppliername',
        'supplieraddress',
        'supplierphone',
        'supplierpreviousdue',
        'status'
    ];
    public function suppliers()
    {
        return $this->hasMany(Purchases::class, 'id');
    }
    use HasFactory;
}
