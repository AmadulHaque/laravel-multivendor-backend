<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Media\HasMedia;
use App\Media\Mediable;

class SubCategory extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'slug', 'category_id', 'status', 'added_by'];
    
    protected $appends = ['image'];

   
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subchilds()
    {
        return $this->hasMany(SubCategoryChild::class);
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
