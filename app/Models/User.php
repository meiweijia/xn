<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tel', 'open_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            //创建token
            if (!$model->api_token) {
                $model->api_token = Str::random(80);
                if (!$model->api_token) {
                    return false;
                }
            }
            //默认头像
            if (!$model->avatar) {
                $model->avatar = asset('storage/images/avatar/default.png');
            }
        });
    }

    public function advises()
    {
        return $this->hasMany(Advise::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function house()
    {
        return $this->hasOne(House::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function regetCards()
    {
        return $this->hasMany(RegetCard::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
