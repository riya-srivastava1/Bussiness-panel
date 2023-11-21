<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserBooking extends Eloquent
{
    protected $dates = ['booking_date_dbf'];
    protected $fillable = [
        'order_id',
        'user_id',
        'vendor_id',
        'tansaction_id',
        'payment_mode',
        'payment_time',
        'getway_name',
        'bank_transaction_id',
        'bank_name',

        'status', //payment Status
        'booking_status',
        'service_status',
        'user_payment_mode', //cash,paytm/card

        'is_canceled',
        'is_rescheduled',
        'canceled_reason',
        'canceled_by',


        'total_services',
        'services',
        'booking_date',
        'booking_date_dbf',
        'booking_time',

        'pay_with',
        'amount',
        'gst',
        'coupon_discount',
        'coupon_history_id',
        'wallet_discount',
        'wallet_history_id',
        'booking_charge',
        'save_amount',
        'net_amount',
        'additional_amount',

        'user_otp_auth',
        'user_otp_num',

        'is_transaction', //when generate transaction = true
    ];


    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class, 'vendor_id', 'vendor_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function business()
    {
        return $this->belongsTo(Business::class, 'vendor_id', 'vendor_id');
    }

    public function refund()
    {
        return $this->hasOne(RefundCancellation::class, 'order_id', 'order_id');
    }

    public function coupon()
    {
        return $this->belongsTo(CouponHistory::class, 'coupon_history_id', '_id');
    }

    public function artist()
    {
        return $this->belongsTo(WahArtist::class, 'wah_artist_id', '_id');
    }
}
