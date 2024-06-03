<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customername',
        'customeraddress',
        'customerphone',
        'customerpreviousdue',
        'customercreditlimit',
        'status'
    ];
    use HasFactory;
}
