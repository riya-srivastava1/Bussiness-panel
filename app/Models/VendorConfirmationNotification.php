<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorConfirmationNotification extends Eloquent
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'vendor_id',
        'data',
        'accept',
        'closetime',
        'username',
        'device_token',
        'vendor_device_token',
        'is_action',
        'status'
    ];
}
