<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function stockInventory()
    {
        return $this->hasOne(StockInventory::class);
    }
    public function variationAttributes()
    {
        return $this->hasMany(VariationAttribute::class);
    }
}
