<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerTarget extends Model
{
    protected $fillable = [
      'user_id', 'item_id', 'target_count', 'start_date', 'end_date', 'name' ,'creator_id', 'description'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function seller()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
