<?php

namespace App\Http\Controllers\TraitClass;

use App\VendorProfile;
use Illuminate\Support\Str;

trait CreateSlugUrlTrait
{

    public function getSlugUrl($vendorProfile)
    {
        $business_name = strtolower($vendorProfile->business_name);
        $locality = strtolower($vendorProfile->locality);
        if(Str::contains($business_name, $locality)){
            $business_name =  Str::replaceFirst($locality, '', $business_name);
        }
        $slug = Str::slug($business_name, '-') .
            '-' . Str::slug($locality, '-') .
            '-' . Str::slug($vendorProfile->city, '-');
        if (VendorProfile::where('vendor_id','!=',$vendorProfile->vendor_id)->where('slug', $slug)->count()) {
            $slug = Str::slug($business_name, '-') .
                '-' . Str::slug($locality, '-') .
                '-' . Str::slug($vendorProfile->city, '-') . '-' . substr(time(), -5);
        }
        return $slug;
    }
}
