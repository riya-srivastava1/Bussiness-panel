<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
// use Illuminate\Database\Eloquent\Model;
class ManageCalendar extends Eloquent
{
    protected $fillable = [
        'vendor_id',
        'date',
        'time',
        'limit'
    ];
}
