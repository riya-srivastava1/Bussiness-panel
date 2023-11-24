<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorStylist extends Eloquent
{
    protected $path = "uploads/business/stylists/";
    protected $fillable = [
        'vendor_id',
        'name',
        'title',
        'experience',
        'speciality',
        'image',
        'gender_served'
    ];

    // public function getImageAttribute($file)
    // {
    //     return $this->path.$file;
    // }
}
