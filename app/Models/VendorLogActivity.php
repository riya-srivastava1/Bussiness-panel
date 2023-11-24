<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorLogActivity extends Eloquent
{
    protected $fillable = ['vendor_id','msg'];
}
