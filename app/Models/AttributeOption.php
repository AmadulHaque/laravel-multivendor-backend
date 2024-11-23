<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    // Define an accessor for the custom attribute
    public function getFormattedOptionAttribute()
    {
        $user = $this->user;
        return [
            'id' => $this->id,
            'attribute_value' => $this->attribute_value,
            'added_by' => $user ? $user->name : '',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
        ];
    }

    // Append the accessor to include in the JSON response
    protected $appends = ['formatted_option'];
}
