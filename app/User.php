<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password', 'ic_number', 'ic_photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_enable' => 'bool'
    ];

    public function findForPassport($login)
    {
        return $this->where('mobile', $login)
            ->where('is_enable', true)
            ->first();
    }

    public function watchers()
    {
        return $this->hasMany(Watcher::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
