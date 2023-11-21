<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorDocument extends Eloquent
{
    protected $fillable = [
        'vendor_id',
        'business_certificate_image',
        'pan_no',
        'pan_image',
        'gst_no',
        'bank_name',
        'branch_name',
        'account_no',
        'account_holder',
        'ifsc',
        'kyc',
    ];

    public function getPanImageAttribute($file){
        return "/uploads/business/pan/".$file;
    }
    public function getBusinessCertificateImageAttribute($file){
        return "/uploads/business/business_certificate/".$file;
    }
    public function setPanNoAttribute($pan){
        $this->attributes['pan_no']=strtoupper($pan);
    }
    public function setIfscAttribute($ifsc){
        $this->attributes['ifsc']=strtoupper($ifsc);
    }
    public function setGstNoAttribute($gst_no){
        $this->attributes['gst_no']=strtoupper($gst_no);
    }
    public function setBranchNameAttribute($branch_name){
        $this->attributes['branch_name']=ucfirst($branch_name);
    }
}

