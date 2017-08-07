<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutletSeller extends Model
{
    protected $fillable = [
      'outlet_id', 'seller_id', 'supervisor_id', 'verified_at' ,'verified'
    ];

    protected $dates = ['verified_at'];

    public $with = ['seller'];

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\User', 'supervisor_id');
    }
}
