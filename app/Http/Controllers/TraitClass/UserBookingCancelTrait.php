<?php

namespace App\Http\Controllers\TraitClass;

use App\Business;
use App\CouponHistory;
use App\Mail\UserCancellationMail;
use App\Mail\VendorCancellationMail;
use App\Mail\ZoyleeCancellationMail;
use App\RefundCancellation;
use App\WalletHistory;
use Illuminate\Support\Facades\Mail;
use Throwable;

trait UserBookingCancelTrait
{
    //check cancel parameters compare date-time and check if already cancelled
    protected function isNotCancel($booking, $plateform = 'user')
    {
        if ($plateform === 'user' && $this->isLessThenTwentyfourHour($booking->booking_date, $booking->booking_time)) {
            $status = true;
            $msg = 'You can cancel your appointment 24 hours prior to your scheduled time.';
        } else if ($booking && ($booking->refund || $booking->is_canceled)) {
            $status = true;
            $msg = 'This appointment has already been cancelled.';
        } else {
            $status = false;
            $msg = "";
        }
        return ['status' => $status, 'msg' => $msg];
    }



    //If success cancellation then send email and msg
    protected function sendCancelNotification($booking, $user)
    {
        $business = $booking->business;
        $business_email = $business->email ?? false;
        $business_phone = $business->owner_contact ?? false;
        if ($business->notify_to == 'parent') {
            $parentBusiness = Business::where('vendor_id', $business->parent_id)->first();
            $business_email = $parentBusiness->email ?? false;
            $business_phone = $parentBusiness->owner_contact ?? false;
        }

        $business_name  = $booking->vendorProfile->business_name ?? 'Partner';


        $vendor_sms = "Dear $business_name, the appointment scheduled by $user->name on " . date('D, M d', strtotime($booking->booking_date)) . " at $booking->booking_time has been cancelled. We apologize for the inconvenience caused. Team Zoylee\n";
        $user_sms = "Dear $user->name, your appointment with $business_name on " . date('D, M d', strtotime($booking->booking_date)) . " at $booking->booking_time has been cancelled. Team Zoylee";
        try {
            //Send mail
            $business_email ? Mail::to($business_email)->send(new VendorCancellationMail($user, $booking)) : '';
            Mail::to($user->email)->send(new UserCancellationMail($user, $booking));
            Mail::to("order@zoylee.com")->send(new ZoyleeCancellationMail($user, $booking));
            //send SMS
            $business_phone ? $this->sendSimpleMsg($business_phone, $vendor_sms, '1007903036190498615') : '';
            !empty($user->phone) ? $this->sendSimpleMsg($user->phone, $user_sms, "1007348262364001046") : '';
        } catch (Throwable $e) {
            report($e);
        }
    }


    /* Update wallet and coupon history when cancel service */
    protected function updateCouponWalletHistory($booking, $user)
    {
        if (intval($booking->wallet_discount) > 0 &&  $booking->wallet_history_id) {
            $wallet = WalletHistory::find($booking->wallet_history_id);
            if ($wallet->status) {
                $user->wallet_amount = $user->wallet_amount + $wallet->value;
                $user->save();
                $wallet->is_refund = true;
                $wallet->save();
            }
        }
        if (intval($booking->coupon_discount) > 0 && $booking->coupon_history_id) {
            $coupon = CouponHistory::find($booking->coupon_history_id);
            if ($coupon->status) {
                $coupon->status = true;
                $coupon->is_refund = true;
                $coupon->save();
            }
        }
    }

    /* Update Refund Cancellation (Online case) */
    protected function updateRefund($booking)
    {
        // $result = $this->refundAmount($booking->transaction_id, $booking->order_id, $booking->net_amount);
        // $result = json_decode($result, true);
        $refund                 =   new RefundCancellation();
        $refund->user_id        =   $booking->user_id;
        $refund->vendor_id      =   $booking->vendor_id;
        $refund->order_id       =   $booking->order_id;
        $refund->amount         =   $booking->net_amount;
        $refund->plateform      =   'app';
        $refund->status         =   false;
        // Paytm data
        // $refund->ref_id          =   "REFUNDID_" . $booking->order_id;
        // $refund->result_status   =   $result['body']['resultInfo']['resultStatus'];
        // $refund->result_code     =   $result['body']['resultInfo']['resultCode'];
        // $refund->result_msg      =   $result['body']['resultInfo']['resultMsg'];
        // $refund->txn_id          =   $booking->transaction_id;
        $refund->save();
    }
}
