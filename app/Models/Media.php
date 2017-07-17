<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
      'mediable_id', 'mediable_type', 'folder', 'filename', 'mime', 'size','extension'
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
