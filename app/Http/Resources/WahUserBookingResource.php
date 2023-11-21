<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WahUserBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $serviceData = collect($this->services);

        return [
            'user_name' => $this->user->name ?? '',
            'user_phone' => $this->user->phone ?? '',
            'artist_name' => $this->artist->name ?? '',
            'artist_phone' => $this->artist->phone ?? '',
            'service_name' =>  is_array($serviceData) ? '--' : $serviceData->pluck('name')->implode(','),
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
        ];
    }
}
