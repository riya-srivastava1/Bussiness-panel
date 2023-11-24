<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Service extends Eloquent
{
  protected $fillable = [
    'service_type_id', 'service_name', 'status'
  ];

  public function serviceType(){
    return $this->belongsTo(ServiceType::class);
  }
}
