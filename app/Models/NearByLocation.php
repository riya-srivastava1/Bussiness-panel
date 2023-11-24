<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class NearByLocation extends Eloquent
{
    protected $fillable = [
        'city',
        'locality',
        'near'
    ];
}
