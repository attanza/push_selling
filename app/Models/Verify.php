<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $fillable = [
      'verifiable_id', 'verifiable_type', 'code',
    ];

    public function verifiable()
    {
        return $this->morphTo();
    }
}
