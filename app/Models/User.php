<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'phone',
        'name',
        'email',
        'password',
        'device_token',
        'image',
        'device_type', //0=ios,1=android
        'login_type', //1=facebook,2=google
        'social_id',
        'is_mobile_verified',
        'is_email_verified',
        'last_login',
        'wallet_amount',
        'remember_token'
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

    public function booking()
    {
        return $this->hasMany(UserBooking::class, 'user_id', 'user_id')
            ->where('service_status', true);
    }

    public function bookingCanceled()
    {
        return $this->belongsTo(UserBooking::class, 'user_id', 'user_id')
            ->where('is_canceled',  true)
            ->where('service_status', '!=', true);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'user_id', 'user_id');
    }
}
