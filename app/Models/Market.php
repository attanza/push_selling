<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Market extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['area_id', 'name', 'slug', 'address', 'photo', 'lat', 'lng'];

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
