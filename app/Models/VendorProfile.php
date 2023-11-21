<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use function PHPSTORM_META\map;

class VendorProfile extends Eloquent
{

    protected $fillable = [
        'vendor_id',
        'about',
        'banner',
        'logo',
        'business_name',
        'owner_name',
        'owner_contact',
        'vendor_type',
        'category_type',
        'service_type',
        'landline_number',
        'opening_time',
        'closing_time',
        'working_day',
        'locality',
        'area',
        'city',
        'zipcode',
        'state',
        'country',
        'full_address',
        'location',
        'amenity',
        'lat',
        'lng',
        'near',
        'is_mobile_verified',
        'is_email_verified',
        'facebook_profile',
        'instagram_profile',
        'website_url',
        'slug',
        'isNotify', // send successfully registration
        'notify_to', // parent or same branch

        'status',
        'max_discount',
        'min_price',
        'avg_rating',
        'total_rating',
        'map_place_id'

    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'vendor_id');
    }

    public function getBannerAttribute($file)
    {
        return "/uploads/business/banners/" . $file;
    }
    public function getLogoAttribute($file)
    {
        return "/uploads/business/logo/" . $file;
    }
    public function vendorDocument()
    {
        return $this->hasOne(VendorDocument::class, "vendor_id", 'vendor_id');
    }
    public function services()
    {
        return $this->hasMany(VendorService::class, 'vendor_id', 'vendor_id');
    }

    public function booking()
    {
        return $this->hasMany(UserBooking::class, 'vendor_id', 'vendor_id');
    }
    public function bookingCompleted()
    {
        return $this->hasMany(UserBooking::class, 'vendor_id', 'vendor_id')->where('service_status', true);
    }
}
