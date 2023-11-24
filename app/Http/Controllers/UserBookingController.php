<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Throwable;
use App\CouponHistory;
use App\WalletHistory;
use App\Models\Business;
use App\Models\UserBooking;
use App\RefundCancellation;
use Illuminate\Http\Request;
use App\Mail\BookingCompleteMail;
use App\Mail\UserCancellationMail;
use App\Http\Controllers\Controller;
use App\Mail\VendorCancellationMail;
use App\Mail\ZoyleeCancellationMail;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\UserBookingResource;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Http\Controllers\TraitClass\RefundAmountTrait;
use App\Http\Controllers\TraitClass\UserBookingCancelTrait;
use App\Http\Controllers\TraitClass\IsTwentyfourHourDifferenceTrait;

class UserBookingController extends Controller
{
    use RefundAmountTrait;
    use SMSTrait;
    use IsTwentyfourHourDifferenceTrait;
    use UserBookingCancelTrait;

    public function served(Request $request)
    {
        $request->validate(['id' => 'required']);
        try {
            $responseMsg = "Great! You have marked this service completed.";
            $getData = UserBooking::find($request->id);
            $vendorServiceStatus = $request->vendor_service_status;
            $user_payment_mode = $request->user_payment_mode;
            $canceled_reason = $request->canceled_reason;
            $user = User::where('user_id', $getData->user_id)->first();
            if ($vendorServiceStatus === "Completed") {
                $getData->service_status = true;
                if ($getData->pay_with === "pay_at_counter") {
                    $getData->status = "complete";
                    $getData->user_payment_mode = $user_payment_mode;
                }
                try {
                    $business_name =  $getData->vendorProfile->business_name ?? 'Partner';
                    Mail::to($user->email)->send(new BookingCompleteMail($user->name, $business_name));
                } catch (Exception $ex) {
                    report($ex);
                }
            } else {
                $checkIsNotCancle = $this->isNotCancel($getData, 'business');
                if ($checkIsNotCancle['status']) {
                    return  response()->json(['status' => false, 'msg' => $checkIsNotCancle['msg']]);
                }
                $getData->service_status = false;
                $getData->is_canceled = true;
                $getData->canceled_by = 'vendor';
                $getData->canceled_reason = empty($canceled_reason) ? 'No Show' : $canceled_reason;
                $responseMsg = empty($canceled_reason) ? "Oops, looks like the customer missed out on a great service." : "Ahh, the booking has been canceled. ";

                try {
                    if ($getData->pay_with === "online") {
                        $this->updateRefund($getData);
                    }
                    if (!(empty($canceled_reason) || $canceled_reason == 'No Show')) {
                        \Log::info($request);
                        $this->updateCouponWalletHistory($getData, $user);
                    }
                    $this->sendCancelNotification($getData, $user);
                } catch (Exception $ex) {
                    report($ex);
                }
            }
            $getData->save();
            return back()->with('success', $responseMsg);
        } catch (Exception $ex) {
            report($ex);
            return back()->with('info', 'Not Updated! Please Contact our Support ');
        }
    }


    public function cancelService(Request $request)
    {
        $request->validate(['id' => 'required', 'cancel_reason' => 'required']);
        $booking = UserBooking::with(['user', 'business'])->find($request->id);
        if ($booking && $booking->refund) {
            return  back()->with('info', 'This appointment has already been cancelled.');
        }
        // if ($booking && (strtotime($booking->booking_date) > strtotime(date('d-m-Y'))) && !($booking->is_canceled)) {
        if ($booking && !($booking->is_canceled)) {

            $booking->service_status = false;
            $booking->is_canceled = true;
            $booking->canceled_by = 'vendor';
            $booking->canceled_reason = empty($request->cancel_reason) ? 'No Show' : $request->cancel_reason;
            $booking->save();
            $user = $booking->user;

            try {
                if ($booking->pay_with === 'online') {
                    $this->updateRefund($booking);
                }
                $this->updateCouponWalletHistory($booking, $user);
                $this->sendCancelNotification($booking, $user);
            } catch (Exception $ex) {
                report($ex);
            }
            return  back()->with('success', 'Appointment has been cancelled.');
        }
        return  back()->with('info', 'This appointment is not aplicable to cancelled.');
    }



    public function totalBooking(Request $request, $vendor_id)
    {
        if ($request->ajax()) {
            $notifyBranchVendorId =  Business::where('parent_id', $vendor_id)
                ->where('notify_to', 'parent')
                ->get(['vendor_id']);
            $notifyBranchVendorId = collect($notifyBranchVendorId);
            $notifyBranchVendorId = $notifyBranchVendorId->pluck('vendor_id');
            $notifyBranchVendorId = $notifyBranchVendorId->push($vendor_id);
            $data = UserBookingResource::collection(UserBooking::whereIn('vendor_id', $notifyBranchVendorId)
                ->where('booking_status', true)
                ->orderByDesc('created_at')
                ->with(['vendorProfile:vendor_id,business_name,locality,city'])
                ->get());
            return DataTables::of($data)->addIndexColumn()->toJson();
        }
        return view('business.user-booking.total-booking', compact('vendor_id'));
    }
    public function booking()
    {
        return Datatables::of(UserBooking::query())->make(true);
    }
    public function onlinePayment(Request $request, $vendor_id)
    {
        if ($request->ajax()) {
            $notifyBranchVendorId =  Business::where('parent_id', $vendor_id)
                ->where('notify_to', 'parent')
                ->get(['vendor_id']);
            $notifyBranchVendorId = collect($notifyBranchVendorId);
            $notifyBranchVendorId = $notifyBranchVendorId->pluck('vendor_id');
            $notifyBranchVendorId = $notifyBranchVendorId->push($vendor_id);
            $data = UserBookingResource::collection(UserBooking::whereIn('vendor_id', $notifyBranchVendorId)
                ->where('booking_status', true)
                ->where('pay_with', 'online')
                ->orderByDesc('created_at')
                ->with(['vendorProfile:vendor_id,business_name,locality,city'])
                ->get());
            return Datatables::of($data)->addIndexColumn()->toJson();
        }
        return view('business.user-booking.online-payment', compact('vendor_id'));
    }
    public function cashPayment(Request $request, $vendor_id)
    {
        if ($request->ajax()) {
            $notifyBranchVendorId =  Business::where('parent_id', $vendor_id)
                ->where('notify_to', 'parent')
                ->get(['vendor_id']);
            $notifyBranchVendorId = collect($notifyBranchVendorId);
            $notifyBranchVendorId = $notifyBranchVendorId->pluck('vendor_id');
            $notifyBranchVendorId = $notifyBranchVendorId->push($vendor_id);
            $data = UserBookingResource::collection(UserBooking::whereIn('vendor_id', $notifyBranchVendorId)
                ->where('booking_status', true)
                ->where('pay_with', 'pay_at_counter')
                ->orderByDesc('created_at')
                ->with(['vendorProfile:vendor_id,business_name,locality,city'])
                ->get());
            return Datatables::of($data)->addIndexColumn()->toJson();
        }
        return view('user-booking.cash-payment', compact('vendor_id'));
    }
}
