<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'seller_id', 'item_id', 'outlet_id', 'qty', 'verified', 'verified_at', 'supervisor_id', 'description'
    ];

    protected $dates = ['verified_at'];

    public $with = ['seller', 'item', 'outlet', 'supervisor'];

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\User', 'supervisor_id');
    }

    public function verifies()
    {
        return $this->morphMany('App\Models\Verify', 'verifiable');
    }
}
