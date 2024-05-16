<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

}
