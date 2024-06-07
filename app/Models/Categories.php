<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'catname',
        'status'
    ];

    public function Categories()
    {
        return $this->hasMany(Categories::class, 'cat_id');
    }
    public function Sales()
    {
        return $this->hasMany(Sales::class, 'cat_id');
    }
    use HasFactory;
}
