<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'brand', 'purchase_price', 'sale_price', 'stock'
    ];

    // Si la tabla no se llama 'products', puedes especificarlo aquí
    protected $table = 'products';  // Asegúrate de que esto coincida con el nombre de tu tabla

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}


