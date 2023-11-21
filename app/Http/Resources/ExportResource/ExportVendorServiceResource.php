<?php

namespace App\Http\Resources\ExportResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportVendorServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'business_name' => $this->vendorProfile->business_name,
            'address' => $this->vendorProfile->locality . ', ' . $this->vendorProfile->city,
            'service_name' => $this->type == 'package' ? 'Package | ' . $this->package_name : $this->service_name,
            'actual_price' => $this->actual_price,
            'discount' => $this->discount,
            'discount_price' => $this->discount_price
        ];
    }
}
