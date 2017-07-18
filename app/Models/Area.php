<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','description'];

    public function markets()
    {
        return $this->hasMany('App\Models\Market');
    }

    public function stokiests()
    {
        return $this->belongsToMany('App\Models\Stokiest');
    }
}
