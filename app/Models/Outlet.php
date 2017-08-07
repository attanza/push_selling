<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
      'market_id', 'code', 'name', 'owner', 'pic', 'phone1', 'phone2', 'email', 'address', 'lat', 'lng'
    ];

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Market');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\OutletSeller');
    }
}
