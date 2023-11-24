<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BusinessNotification extends Eloquent
{
    protected $fillable = [
        'vendor_id',
        'img',
        'title',
        'description',
        'payload'
    ];
}
