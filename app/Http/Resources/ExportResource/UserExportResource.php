<?php

namespace App\Http\Resources\ExportResource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $booking = $this->booking[0] ?? [];
        $booking_type = $booking->type ?? 'vendor';
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'booking_date_time' => ($booking->booking_date ?? '') . ', ' . ($booking->booking_time ?? ''),
            'type' => $booking_type,
            'city' => $booking_type == 'wah' ? $booking->address['address_1'] ?? '' : $booking->vendorProfile->city ?? '',
            'registered_date' => date('d-m-Y', strtotime($this->created_at))
        ];
    }
}
