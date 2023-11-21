<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WahBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->coupon_discount) {
            $discount = $this->coupon_discount;
            $discount_media = 'Coupon';
        } else {
            $discount_media = 'Wallet';
            $discount = $this->wallet_discount;
        }

        return [
            'name' => $this->user->name,
            'phone' => $this->user->phone,
            'city' => $this->address['address_1'],
            'booking_date_time' => ($this->booking_date ?? '') . ', ' . $this->booking_time ?? '',
            'amount' => $this->amount,
            'coupon_wallet_discount' => $discount,
            'discount_media' => $discount_media,
            'net_amount' => $this->net_amount
        ];
    }
}
