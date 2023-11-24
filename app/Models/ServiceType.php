<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ServiceType extends Eloquent
{
    protected $path = '/uploads/super-admin/service-type/';
    protected $fillable = [
        'category_id','service_type_name','status','tag_line','image'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function service(){
        return $this->hasMany(Service::class);
    }

    public function getImageAttribute($file){
        return $this->path.$file;
    }
}
