<?php

namespace App\Http\Resources\ExportResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportVendorEmailPhoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = 'salon';
        $getCategoryTypeData = $this->vendor_profile->category_type ?? '';
        if (!empty($getCategoryTypeData)) {
            $categoryTypeData = explode(',', $getCategoryTypeData);
            $categoryTypeData = $categoryTypeData[0];
            if (!empty($categoryTypeData)) {
                $category = strtolower($categoryTypeData);
            }
        }

        return [
            'business_name' => $this->vendor_profile->business_name ?? '',
            'owner_name' => $this->vendor_profile->owner_name ?? '',
            'about' => $this->vendor_profile->about ?? '',
            'banner' => cdn($this->vendor_profile->banner ?? '') ?? '',
            'email' => $this->email,
            'gender' => $this->vendor_profile->vendor_type ?? '',
            'category_type' => $this->vendor_profile->category_type ?? '',
            'phone' => $this->owner_contact,
            'url' => "https://www.zoylee.com/$category/" . $this->vendor_profile->slug,
            'lat' => $this->vendor_profile->near['coordinates'][1] ?? 0,
            'lng' => $this->vendor_profile->near['coordinates'][0] ?? 0,
            'city' => $this->vendor_profile->city,
            'locality' => $this->vendor_profile->locality,
            'full_address' => $this->vendor_profile->full_address,
            'zipcode' => $this->vendor_profile->zipcode,
            // 'booking_count' => $this->booking->count(),
            // 'completed_booking' => $this->bookingCompleted ? $this->bookingCompleted->count() : 0,
        ];
    }
}
