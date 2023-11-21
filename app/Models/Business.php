<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use App\Models\VendorProfile;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Business extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id', 'parent_id', 'label', 'owner_contact', 'email', 'password', 'show_password', 'status', 'step'
    ];
    protected $hidden = [
        'password', 'remember_token', 'show_password'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendor_profile()
    {
        return $this->hasOne(VendorProfile::class, 'vendor_id', 'vendor_id');
    }
    public function vendorProfileActive()
    {
        return $this->hasOne(VendorProfile::class, 'vendor_id', 'vendor_id')
            ->where('status', true);
    }
    public function vendorProfileInActive()
    {
        return $this->hasOne(VendorProfile::class, 'vendor_id', 'vendor_id')
            ->where('status', '!=', true);
    }
    public function vendor_document()
    {
        return $this->hasOne(VendorDocument::class, 'vendor_id', 'vendor_id');
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function businessLogin()
    {
        return $this->hasOne(BusinessLoginStatus::class, 'vendor_id', 'vendor_id');
    }

    public function booking()
    {
        return $this->belongsTo(UserBooking::class, 'vendor_id', 'vendor_id');
    }

    public function bookingCompleted()
    {
        return $this->belongsTo(UserBooking::class, 'vendor_id', 'vendor_id')->where('service_status', true);
    }
}
