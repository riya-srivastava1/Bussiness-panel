<?php

namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VendorService extends Eloquent
{
    // protected $connection = "mongodb";
    // protected $collection = "vendor_services";
    protected $path = "uploads/business/services/";

    protected $fillable = [
        'vendor_id',
        'service_id',
        'service_type_name',
        'type',
        'created_by',
        'package_name',
        'package_category',
        'package_description',
        'sub_service_name',
        'duration',
        'available_for',


        'actual_price', //service price
        'discount_type', //1 = flat,2=percentage
        'discount',
        'discount_valid',
        'actual_discount_amount',
        'discount_price', //list price or after discount price

        'after_discount_price',

        'gst',
        'pre_gst_amount',
        'list_price',
        'final_vendor_collection',
        'vendor_earning',
        'internet_charge',
        'internet_charge_amount',
        'settlement_amount',

        'commission_on', // with_gst=1,without_gst=2
        'commission_type', // 1=flat,2=percentage
        'commission',
        'commission_pass_on',
        'commission_amount',
        'zoylee_net_income',
        'zoylee_user_discount',
        'final_zoylee_income',

        'status'
    ];

    // public function getImageAttribute($file)
    // {
    //     return $this->path.$file;
    // }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class, 'vendor_id', 'vendor_id');
    }
}
