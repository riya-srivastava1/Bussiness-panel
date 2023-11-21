<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Amenity extends Eloquent
{
    protected $fillable = [
        'name',
        'icon'
    ];

    public function getIconAttribute($icon){
        return $icon;
    }
}
