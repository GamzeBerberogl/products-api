<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'product_type_id',
        'price_sign_id',
        'currency_type_id',
        'name',
        'price',
        'image_link',
        'description',
        'is_active'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categpry::class, 'category_id', 'id');
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function priceSign()
    {
        return $this->belongsTo(PriceSign::class, 'price_sign_id', 'id');
    }
    
    public function currencyType()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id', 'id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

}
