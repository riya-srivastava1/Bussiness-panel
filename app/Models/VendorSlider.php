<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorSlider extends Eloquent
{

    protected $path = "uploads/business/sliders/";

    protected $fillable = [
        'vendor_id', 'image', 'title'
    ];
    public function getImageAttribute($file)
    {
        return $this->path . $file;
    }
}
