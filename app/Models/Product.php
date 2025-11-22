<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku','name','category','unit',
        'purchase_price','selling_price',
        'stock','status','description','image'
    ];

    protected $appends = ['formatted_selling_price'];

    public function getFormattedSellingPriceAttribute()
    {
        return 'Rp ' . number_format($this->selling_price, 0, ',', '.');
    }
}
