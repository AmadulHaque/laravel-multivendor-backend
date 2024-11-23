<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Media\HasMedia;
use App\Media\Mediable;

class Product extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $guarded = [];
    protected $appends = ['image'];


    public static $PRODUCT_TYPE_SINGLE = 1;
    public static $PRODUCT_TYPE_VARIANT = 2;
    public static $SELLING_TYPE_RETAIL = 1;
    public static $SELLING_TYPE_WHOLESALE = 2;

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return $this->getUrl('images');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetails::class, 'product_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subCategoryChild()
    {
        return $this->belongsTo(SubCategoryChild::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

}
