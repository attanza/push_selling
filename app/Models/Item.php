<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;

class Item extends Model
{
    protected $fillable = [
        'code', 'name', 'measurement', 'price', 'target_by', 'target_count', 'start_date', 'end_date'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }

    public function targets()
    {
        return $this->hasMany('App\Models\SellerTarget');
    }

    public function getFirstPhoto()
    {
        if (count($this->medias)>0) {
            $media = $this->medias()->first();
            $path = $media->folder.$media->filename;
            if (!Storage::disk('local')->exists($path)) {
                return asset('images/product.png');
            } else {
                return asset(Storage::url($path));
            }
        } else {
            return asset('images/product.png');
        }
    }
}
