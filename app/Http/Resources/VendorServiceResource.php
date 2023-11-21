<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category_or_service_type_name = '';
        $service_or_package_name = '';
        $sub_service_or_package_dis = '';
        if ($this->type == "package") {
            $category_or_service_type_name = $this->service_type_name;
            $service_or_package_name       = $this->package_name;
            $sub_service_or_package_dis    = $this->package_description;
        } else {
            if ($this->service && $this->service->serviceType) {
                $category_or_service_type_name = $this->service->serviceType->service_type_name;
            }
            $service_or_package_name       = $this->service ? $this->service->service_name : '';
            $sub_service_or_package_dis    = $this->sub_service_name;
        }
        return [
            'id'               =>  $this->id,
            'category_or_service_type_name' =>  $category_or_service_type_name,
            'service_or_package_name'       =>  $service_or_package_name,
            'sub_service_or_package_dis'    =>  $sub_service_or_package_dis,
            'vendor_id'         =>  $this->vendor_id,
            'type'              =>  $this->type,
            'duration'          =>  $this->duration . ' min',
            'actual_price'      =>  doubleval($this->actual_price),
            'discount_price'    =>  doubleval($this->discount_price),
            'image'             =>  $this->image,
            'available_for'     =>  $this->available_for,
            'discount'          =>  doubleval($this->discount) . '%',
            'discount_type'     =>  $this->discount_type,
            'discount_valid'    =>  $this->discount_valid . ' d',
            'status'            =>  $this->status
        ];
    }
}
