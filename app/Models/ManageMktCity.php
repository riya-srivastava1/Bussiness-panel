<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ManageMktCity extends Eloquent
{
    protected $fillable = [
        'manage_mkt_zone_id',
        'city_name'
    ];

    public function manageMktZone(){
        return $this->belongsTo(ManageMktZone::class);
    }
}
