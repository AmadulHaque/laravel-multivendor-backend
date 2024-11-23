<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Media\HasMedia;
use App\Media\Mediable;

class SubCategoryChild extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'slug', 'sub_category_id', 'status', 'added_by'];
    
    protected $appends = ['image'];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return null;// $this->getUrl('images')[0];
    }
}
