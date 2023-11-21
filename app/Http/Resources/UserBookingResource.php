<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class UserBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subServicesData = '';
        $totalAmount = 0;
        if ($this->services) {
            $itemServices = is_array($this->services) ? $this->services : json_decode($this->services);
            $subServicesData = '';
            if (is_array($itemServices)) {
                foreach ($itemServices as $service) {
                    if (is_array($service)) {
                        $totalAmount +=   $service['amount'] ?? $service['discount_price'];
                        $sub_service_name =  $service['sub_service_name'] ?? $service['service_name'];
                    } else {
                        $totalAmount +=   $service->amount ?? $service->discount_price;
                        $sub_service_name = $service->sub_service_name;
                    }
                    $subServicesData .= $sub_service_name . ', ';
                }
            }
        }

        $business_name = $this->vendorProfile->business_name ?? '';
        $locality = $this->vendorProfile->locality ?? '';
        $city = $this->vendorProfile->city ?? '';
        $discount_media = '';

        if (!empty(intval($this->coupon_discount))) {
            $discount_media = 'Coupon - ' . $this->coupon->promotion_code;
        } elseif (!empty(intval($this->wallet_discount))) {
            $discount_media = 'Wallet';
        }

        return [
            // 'vendor_id' => $this->vendor_id,
            'business_name' => $business_name,
            'location' =>  $locality . ', ' . $city,
            'order_id' => $this->order_id,
            'services' => substr(trim($subServicesData), 0, -1),
            'datetime' => $this->booking_date . ' / ' . $this->booking_time,
            'amount' => $this->amount,
            'coupon_wallet_discount' => empty(intval($this->coupon_discount)) ? intval($this->wallet_discount) : intval($this->coupon_discount),
            'discount_media' => $discount_media,
            'save_amount' => $this->save_amount,
            'net_amount' => $this->net_amount,
            'pay_with' => $this->pay_with,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : '',
        ];
    }
}
