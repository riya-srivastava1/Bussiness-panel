<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    protected $path = "uploads/super-admin/category/";
    protected $fillable = [
        'category_name',
        'image',
        'status'
    ];

    public function getImageAttribute($file){
        return $this->path.$file;
    }
    public function serviceType(){
        return $this->hasMany(ServiceType::class);
      }
}
