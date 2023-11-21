<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Amenity;
use App\Models\Business;
use App\Models\Category;
use App\Models\UserBooking;
use Illuminate\Support\Arr;
use App\Models\DisabledDate;
use Illuminate\Http\Request;
use App\Models\ManageMktCity;
use App\Models\VendorProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\CloseBookingNotificationEvent;
use App\Http\Controllers\TraitClass\SMSTrait;
use App\Events\ResponseBookingNotificationEvent;
use App\Http\Controllers\NotificationTraitBusiness;

class BusinessController extends Controller
{
    use NotificationTraitBusiness;
    use SMSTrait;

    public function __construct()
    {
        ini_set('max_execution_time', 333);
    }
    public function testNotification()
    {
        return $this->sendSimpleMsg('8127752685', 'Testing');
        $device_token = "fERP-YwQQnia4ViBXQXPpR:APA91bGx07hmATdl1CJ0phzmgwS6McbTdWURwqWbdABfRI0IsVpABQugK9tHq4UxscupDNgmHT7XNZcMtZQ3mCe2XZqTJUuXcMMHyE49EY1EfPNpazoi14lNvQnYzv0XzKXPwQPOmsQK";
        $title = "Confirmation";
        $body = "The time slot has been reserved for you. Kindly complete the payment for booking confirmation.";
        $payload = ['push-type' => 'co nfirmation', 'status' => 'accept'];
        // $this->sendNotification($device_token, $title, $body, $payload);
        echo "done!";
    }

    public function getUserRequestForBooking()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $getReq = VendorConfirmationNotification::where('vendor_id', $vendor_id)->where('status', 0)->whereBetween('created_at', [now()->subHours(54), now()])->get();
        if ($getReq != null && $getReq->count() > 0) {
            echo json_encode($getReq);
            exit;
        }
        echo "no-data";
        exit;
    }

    public function confirmUserBooking(Request $request)
    {
        $notification_id = $request->get('notification_id');
        $getVCN = VendorConfirmationNotification::where('notification_id', $notification_id)->first();
        if ($getVCN->is_action) {
            return response()->json(['status' => false, 'msg' => 'You have already marked this booking.']);
        }
        $getVCN->status = 1;
        $getVCN->is_action = true;
        if ($getVCN->save()) {
            $date = '';
            $time = '';
            $data = json_decode($getVCN->data);
            foreach ($data as $d) {
                $date = $d->datetime->date;
                $time = $d->datetime->time;
                break;
            }
            $saveHoldTimeData = [
                'notification_id' => $notification_id,
                'date' => $date,
                'time' => $time,
                'user_id' => $getVCN->user_id,
                'vendor_id' => $getVCN->vendor_id,
                'plateform' => 'web'
            ];
            // HoldTimeSlot::create($saveHoldTimeData);

            try {
                event(new ResponseBookingNotificationEvent($saveHoldTimeData));
                event(new CloseBookingNotificationEvent($saveHoldTimeData));
                $time = date("g:i a", strtotime($time));
                $title = "Booking Accepted";
                $description = "An appointment by $getVCN->username at $time, $date has been scheduled successfully.";
                $notification = new BusinessNotification;
                $notification->vendor_id = $getVCN->vendor_id;
                $notification->title = $title;
                $notification->description = $description;
                $notification->payload = $saveHoldTimeData;
                $notification->save();
                $this->notification(
                    $getVCN->vendor_device_token,
                    $title,
                    $description,
                    ['action' => 'notification'],
                    'accept'
                );
            } catch (Exception $ex) {
                report($ex);
            }
            echo "success";
            exit;
        }
        echo "error";
        exit;
    }

    public function rejectUserBooking(Request $request)
    {
        $notification_id = $request->get('notification_id');
        $getVCN = VendorConfirmationNotification::where('notification_id', $notification_id)->first();
        if ($getVCN->is_action) {
            return response()->json(['status' => false, 'msg' => 'You have already marked this booking.']);
        }
        $saveHoldTimeData = ['notification_id' => $notification_id];
        $getVCN->status = 2;
        $getVCN->is_action = true;
        try {
            $date = '';
            $time = '';
            $data = json_decode($getVCN->data);
            foreach ($data as $d) {
                $date = $d->datetime->date;
                $time = $d->datetime->time;
                break;
            }
            event(new ResponseBookingNotificationEvent(['status' => 'reject', 'user_id' => $getVCN->user_id, 'notification_id' => $notification_id]));
            event(new CloseBookingNotificationEvent($saveHoldTimeData));
            $time = date("g:i a", strtotime($time));
            $title = "Booking Rejected";
            $description = "You rejected the appointment scheduled by $getVCN->username at $time, $date.";
            $notification = new BusinessNotification();
            $notification->vendor_id = $getVCN->vendor_id;
            $notification->title = $title;
            $notification->description = $description;
            $notification->payload = ['status' => 'reject', 'user_id' => $getVCN->user_id, 'notification_id' => $notification_id];
            $notification->save();
            $this->notification(
                $getVCN->vendor_device_token,
                $title,
                $description,
                ['action' => 'notification'],
                'reject'
            );
        } catch (Exception $ex) {
            report($ex);
        }
        if ($getVCN->save()) {
            echo "success";
            exit;
        }
        echo "error";
        exit;
    }


    public function dashboard()
    {
        $vendor = Auth::guard('business')->user();
        $vendor_id = $vendor->vendor_id;
        $gst_vendor = false;
        if ($vendor->vendor_document && !empty($vendor->vendor_document->gst_no)) {
            $gst_vendor = true;
        }
        $childBranchBooking =  Business::where('parent_id', $vendor_id)
            ->where('notify_to', 'parent')
            ->get(['vendor_id']);
        $childBranchBooking = collect($childBranchBooking);
        $childBranchBooking = $childBranchBooking->pluck('vendor_id');
        $childBranchBooking = $childBranchBooking->push($vendor_id);


        $recentBooking = UserBooking::whereIn('vendor_id', $childBranchBooking)
            ->where('booking_status', true)
            ->where('service_status', '!=', true)
            ->where('is_canceled', '!=', true)
            ->where('booking_date', date('d-m-Y'))
            ->orderBy('booking_date_dbf')
            ->with(['vendorProfile:vendor_id,business_name,locality,city'])
            ->get();
        $totalRecent = $recentBooking->count();
        $recentBooking = collect($recentBooking);
        $recentBooking = $recentBooking->groupBy('vendor_id');

        $upcoming = UserBooking::whereIn('vendor_id', $childBranchBooking)
            ->where('booking_status', true)
            ->where('service_status', '!=', true)
            ->where('is_canceled', '!=', true)
            ->where('booking_date_dbf', '>', now())
            ->orderBy('booking_date_dbf')
            ->with(['vendorProfile:vendor_id,business_name,locality,city'])
            ->get();
        $totalUpcoming = $upcoming->count();
        $upcoming = collect($upcoming);
        $upcoming = $upcoming->groupBy('vendor_id');

        /*
        return $childTodayBooking;
        $recentBooking = UserBooking::where('vendor_id', $vendor_id)
            ->where('booking_status', true)
            ->where('service_status', '!=', true)
            ->where('is_canceled', '!=', true)
            ->where('booking_date', date('d-m-Y'))
            ->orderBy('booking_time')
            ->get();
        $upcoming = UserBooking::where('vendor_id', $vendor_id)
            ->where('booking_status', true)
            ->where('service_status', '!=', true)
            ->where('is_canceled', '!=', true)
            ->where('booking_date_dbf', '>', now())
            ->orderBy('booking_date')
            ->get();
        */

        return view('dashboard.dashboard', compact([
            'recentBooking',
            'upcoming',
            'vendor_id',
            'gst_vendor',
            'totalRecent',
            'totalUpcoming'
        ]));
    }

    public function signUp()
    {
        $category = Category::whereIn('status', [1, '1'])->get();
        $cities = ManageMktCity::all();
        return view('business.signup', compact(['category', 'cities']));
    }

    public function signUpDummy()
    {
        $category = Category::whereIn('status', [1, '1'])->get();
        $cities = ManageMktCity::all();
        return view('business.marketing-signup', compact(['category', 'cities']));
    }

    public function myAccount()
    {
        $category = Category::whereIn('status', [1, '1'])->get();
        $cities = ManageMktCity::all();
        $serviceType = DB::table('service_types')->distinct()->get(['service_type_name']);
        return view('dashboard.my-account', compact(['category', 'serviceType', 'cities']));
    }

    public function timeManageView()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $disabledDate = DisabledDate::where('vendor_id', $vendor_id)->pluck('date');
        $disabledDate = $disabledDate->toArray();
        return view('dashboard.manage-date-time', compact(['disabledDate']));
    }

    public function validateEmail(Request $request)
    {
        if (Business::where('email', $request->email)->count()) {
            return response()->json(['status' => false, 'message' => "$request->email Email id already exists."]);
        }
        return response()->json(['status' => true, 'message' => "Validated"]);
    }

    public function branch()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $branchs = Business::where('parent_id', $vendor_id)->get();
        return view('dashboard.branch', compact(['branchs']));
    }

    public function updateEditPermission(Request $request)
    {
        $request->validate(['vendor_id' => 'required', 'edit_permission' => 'required']);
        $vendorProfile = VendorProfile::where('vendor_id', $request->vendor_id)->first();
        if ($vendorProfile && $vendorProfile->count()) {
            $vendorProfile->edit_permission = $request->edit_permission;
            $vendorProfile->save();
            return back()->with('success', 'Updated');
        }
        return back()->with('Error', 'Not Updated');
    }

    public function addBranch()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $branchs = Business::where('parent_id', $vendor_id)->get();
        $category = Category::whereIn('status', [1, '1'])->get();
        $cities = ManageMktCity::all();
        return view('dashboard.add-branch', compact(['branchs', 'category', 'cities']));
    }

    public function manageStylist()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $stylists = VendorStylist::where('vendor_id', $vendor_id)->get();
        return view('dashboard.add-manage-artists', compact('stylists'));
    }

    public function userBooking(Request $request)
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $notifyBranchs =  Business::where('parent_id', $vendor_id)
            ->where('notify_to', 'parent')
            ->with(['vendor_profile:vendor_id,business_name,locality,city'])
            ->get(['vendor_id']);
        if (!empty(session()->get('notify_branch_vendor_id'))) {
            $vendor_id = session()->get('notify_branch_vendor_id');
        }
        $vendor_profile  = VendorProfile::where('vendor_id', $vendor_id)->first();
        if (!$request->has('type')) {
            $request['type'] = 'complete';
        }
        if ($request->type == "cancelled") {
            $canclledBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', true)
                ->orderByDesc('updated_at')->paginate(15);

            $completeBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', true)
                ->where('is_canceled', '!=', true)
                ->orderByDesc('updated_at')
                ->count();
            $pendingBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', '!=', true)
                ->where('booking_date_dbf', '<', now()->subHours(20))
                ->orderByDesc('updated_at')
                ->count();
            return view('dashboard.user-booking-cancelled', compact(['canclledBooking', 'completeBooking', 'pendingBooking', 'vendor_profile', 'notifyBranchs']));
        } elseif ($request->type == "pending") {
            $canclledBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', true)
                ->orderByDesc('updated_at')->count();

            $completeBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', true)
                ->where('is_canceled', '!=', true)
                ->orderByDesc('updated_at')
                ->count();
            $pendingBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', '!=', true)
                ->where('booking_date_dbf', '<', now()->subHours(20))
                ->orderByDesc('updated_at')
                ->paginate(15);
            return view('dashboard.user-booking-pending', compact(['canclledBooking', 'completeBooking', 'pendingBooking', 'vendor_profile', 'notifyBranchs']));
        } else {
            $canclledBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', true)
                ->orderByDesc('updated_at')
                ->count();

            $completeBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', true)
                ->where('is_canceled', '!=', true)
                ->orderByDesc('updated_at')
                ->paginate(15);
            $pendingBooking = UserBooking::where('vendor_id', $vendor_id)
                ->where('booking_status', true)
                ->where('service_status', '!=', true)
                ->where('is_canceled', '!=', true)
                ->where('booking_date_dbf', '<', now()->subHours(20))
                ->orderByDesc('updated_at')
                ->count();
            return view('dashboard.user-booking-complete', compact(['canclledBooking', 'completeBooking', 'pendingBooking', 'vendor_profile', 'notifyBranchs']));
        }
    }

    public function userBookingDetails(Request $request)
    {
        $request->validate(['order_id' => 'required', 'type' => 'required']);
        $booking = UserBooking::where('order_id', $request->order_id)->with(['vendorProfile:vendor_id,business_name,locality,city'])->first();
        if ($booking && $booking->count()) {
            $type = $request->type;
            return view('dashboard.user-booking-details', compact(['booking', 'type']));
        }
        return back();
    }

    public function amenities()
    {
        $amenity = Amenity::all();
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $vendorAmenities = VendorProfile::where('vendor_id', $vendor_id)->first();
        $vendorAmenity = null;
        $vendorAmenities = $vendorAmenities->amenity;
        $v = json_decode($vendorAmenities);
        if ($v) {
            $vendorAmenity = Arr::pluck($v, 'name');
        }
        return view('dashboard.amenities', compact(['amenity', 'vendorAmenity']));
    }


    public function logout(Request $request)
    {
        Auth::guard('business')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function checkUser()
    {
        if (Auth::guard('business')->check()) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function googleReV2(Request $request)
    {
        $token = $request->token;
        $client = new \GuzzleHttp\Client();
        $url = "https://www.google.com/recaptcha/api/siteverify";
        // $myBody['response'] = $token;
        // $myBody['secret'] = "6LdWbccUAAAAAKTp5h8UnYwEXfX-w3gYMD3fIugw";

        // $request = $client->post($url,['form_params'=>$myBody]);
        $response = $client->request('POST', $url, [
            'form_params' => [
                'response' => $token,
                'secret' => "6LdlrMsUAAAAAAhKXPgz_RAfgDSX3HWXYP7_dToI"
            ]
        ]);
        $body = $response->getBody();
        // $response = $request->send();
        print_r($body->getContents());
        // echo  $request->token;

    }

    public function updateNotifyBranchSession($vendor_id)
    {
        if (!empty($vendor_id)) {
            session()->put('notify_branch_vendor_id', $vendor_id);
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
