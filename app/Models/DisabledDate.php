<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
// use Illuminate\Database\Eloquent\Model;
class DisabledDate extends Eloquent
{
    protected $fillable = [
        'vendor_id',
        'date',
        'msg'
    ];

    public function getUpdatedAtAttribute($date)
    {
        return null;
    }
    public function getCreatedAtAttribute($date)
    {
        return null;
    }
}
