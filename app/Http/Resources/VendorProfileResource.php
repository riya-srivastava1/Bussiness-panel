<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorProfileResource extends JsonResource
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
            'business_name' => $this->business_name ?? '',
            // 'owner_name' => $this->owner_name ?? '',
            // 'email' => $this->email,
            // 'phone' => $this->owner_contact
            'lat' => $this->near['coordinates'][1] ?? 0,
            'lng' => $this->near['coordinates'][0] ?? 0,
            'city' => $this->city,
            'locality' => $this->locality,
            'zipcode' => $this->zipcode,
        ];
    }
}
