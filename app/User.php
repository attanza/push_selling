<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Storage;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at','last_login'];

    public $with = ['roles'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\UserDetail');
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }

    public function getLastLoginAttribute($value)
    {
        if ($value != null) {
            return Carbon::parse($value)->diffForHumans();
        }
    }

    public function getAvatarAttribute($value)
    {
        if ($value == null) {
            return asset('images/male.png');
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset('images/male.png');
        } else {
            return asset(Storage::url($value));
        }
    }
}
