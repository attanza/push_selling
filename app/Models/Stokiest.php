<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Stokiest extends Model
{
    protected $fillable = [
        'code', 'name', 'address', 'owner', 'pic', 'phone1', 'phone2', 'email', 'photo', 'area_id'
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }

    public function getPhotoAttribute($value)
    {
        if ($value == null) {
            return asset('images/market.png');
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset('images/market.png');
        } else {
            return asset(Storage::url($value));
        }
    }
}
