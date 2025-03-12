<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'brand', 'purchase_price', 'sale_price', 'stock'
    ];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}

