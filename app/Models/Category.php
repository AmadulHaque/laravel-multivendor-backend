<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Media\HasMedia;
use App\Media\Mediable;

class Category extends Model implements Mediable
{
    use HasFactory, HasMedia;
    protected $guarded = [];
    
    protected $appends = ['image'];
    

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return null; // $this->getUrl('images')[0];
    }
}
