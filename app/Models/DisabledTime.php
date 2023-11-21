<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
// use Illuminate\Database\Eloquent\Model;
class DisabledTime extends Eloquent
{
    protected $fillable = [
        'vendor_id',
        'date',
        'time',
    ];
}
