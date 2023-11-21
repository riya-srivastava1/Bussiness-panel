<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubService extends Eloquent
{
    protected $fillable = [
        'services_id',
        'sub_name',
    ];

    public function services(){
        return $this->belongsTo(Service::class,'services_id');
    }
}
