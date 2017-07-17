<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id','ktp','gender','dob','phone1','phone2','address','salary'];

    protected $dates = ['dob'];

    public function user()
    {
        return $this->belogngsTo('App\User');
    }
}
