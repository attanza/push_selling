<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}
