<?php

namespace App\Http\Resources\ExportResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportVendorProfileWithBookingResource extends JsonResource
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
            'owner_name' => $this->owner_name ?? '',
            'email' => $this->email,
            'gender' => $this->vendor_type ?? '',
            'phone' => $this->owner_contact,
            'city' => $this->city,
            'locality' => $this->locality,
            'full_address' => $this->full_address,
            'zipcode' => $this->zipcode,
            'booking_count' => $this->booking->count(),
            'completed_booking' => $this->bookingCompleted ? $this->bookingCompleted->count() : 0,
        ];
    }
}
