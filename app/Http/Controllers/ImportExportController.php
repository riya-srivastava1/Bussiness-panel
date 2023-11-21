<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use App\Exports\UserExport;
use App\Models\UserBooking;
use Illuminate\Support\Arr;
use App\Models\VendorProfile;
use App\Models\VendorService;
use App\Exports\WahBookingExport;
use App\Exports\UserBookingExport;
use App\Exports\ExportVendorBooking;
use App\Exports\ExportVendorService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WahUserBookingExport;
use App\Exports\ExportVendorEmailPhone;
use App\Http\Resources\WahBookingResource;
use App\Http\Resources\UserBookingResource;
use App\Http\Resources\WahUserBookingResource;
use App\Http\Resources\ExportResource\UserExportResource;
use App\Http\Resources\ExportResource\ExportVendorServiceResource;
use App\Http\Resources\ExportResource\ExportVendorEmailPhoneResource;
use App\Http\Resources\ExportResource\ExportVendorProfileWithBookingResource;

class ImportExportController extends Controller
{

    public function __construct()
    {
        //  die(Auth::guard('business')->user()->email);
    }

    public function checkUser()
    {
        if (Auth::guard('business')->user()->email === 'ajay@thesagenext.com') {
            return true;
        }
        abort(404);
    }

    public function export()
    {
        $this->checkUser();
        $vendor = Auth::guard('business')->user();
        $vendor_id = $vendor->vendor_id;
        // $services = VendorService::where('vendor_id', $vendor_id)
        //     ->get(['actual_price', 'discount', 'discount_price', 'service_name', 'type', 'package_name']);
        $services = VendorService::where('available_for', 'Kids')
            ->get(['vendor_id', 'actual_price', 'discount', 'discount_price', 'service_name', 'type', 'package_name']);
        $vendorServices = ExportVendorServiceResource::collection($services);
        return Excel::download(new ExportVendorService($vendorServices), 'vendor-service.xlsx');
    }
    public function exportVendorDetails()
    {
        $this->checkUser();
        // return Business::whereHas('booking')->whereHas('vendor_profile')->get();
        $businessData = VendorProfile::whereHas('booking')
            ->where('city', 'Chandigarh')
            ->get();
        //  return $businessData->count();
        $vendorServices = ExportVendorProfileWithBookingResource::collection($businessData);
        return Excel::download(new ExportVendorBooking($vendorServices), 'chandigarh-vendor-data.csv');
    }
    public function exportVendorDetailsActive()
    {
        $this->checkUser();
        $vendorServices = ExportVendorEmailPhoneResource::collection(Business::whereHas('vendorProfileActive')
            ->with('vendorProfileActive')
            ->get());

        return Excel::download(new ExportVendorEmailPhone($vendorServices), 'active-vendor-data.csv');
    }
    public function exportVendorDetailsInActive()
    {
        $this->checkUser();
        $vendorServices = ExportVendorEmailPhoneResource::collection(Business::whereHas('vendorProfileInActive')
            ->with('vendorProfileInActive')
            ->get());
        return Excel::download(new ExportVendorEmailPhone($vendorServices), 'in-active-vendor-data.csv');
    }
    public function exportUserDetails()
    {
        $this->checkUser();
        $users = UserExportResource::collection(User::orderByDesc('created_at')->get(['email', 'name', 'phone', 'city', 'created_at']));
        $date = date('d-m-Y');
        return Excel::download(new UserExport($users), "users-data-$date.csv");
    }

    public function exportUserDetailsBookingComplete()
    {
        $this->checkUser();
        $data = User::orderByDesc('created_at')->doesntHave('booking')->get();
        $users = UserExportResource::collection($data);
        return Excel::download(new UserExport($users), 'one-booking-users.xlsx');
    }
    public function bookingDataByWah()
    {
        $this->checkUser();
        $data = UserBooking::where('type', 'wah')
            ->where('service_status', true)
            ->orWhere('wallet_discount', '>', 0)
            ->orWhere('coupon_discount', '>', 0)
            ->get();
        $data = WahBookingResource::collection($data);
        return Excel::download(new WahBookingExport($data), 'wah-booking-list.xlsx');
    }

    public function wahBooking()
    {
        $this->checkUser();
        $data = UserBooking::where('type', 'wah')
            ->where('service_status', true)
            ->where('booking_date_dbf', '>=', now()->subDays(30))
            ->get();
        $data = WahUserBookingResource::collection($data);
        $date = date('d-m-Y', strtotime(now()->subDays(30))) . '-to-' . date('d-m-Y');
        return Excel::download(new WahUserBookingExport($data), "wah-booking-list-$date.xlsx");
    }


    public function bookingDataByVendor()
    {
        $booking =  UserBooking::where('type', '!=', 'wah')
            ->where('service_status', true)
            ->where('vendor_id', '!=', '15889393240009044361778')
            ->where('booking_date_dbf', '>=', now()->subDays(30))
            ->get();
        $booking =  UserBookingResource::collection($booking);
        $date = date('d-m-Y', strtotime(now()->subDays(30))) . '-to-' . date('d-m-Y');

        return Excel::download(new UserBookingExport($booking), "vendor-bookoing-$date.xlsx");
    }

    public function exportUserDetailsCartAdded()
    {
        $this->checkUser();
        $users = UserExportResource::collection(User::orderByDesc('created_at')->whereHas('cart')->get(['email', 'name', 'phone']));
        return Excel::download(new UserExport($users), 'cart-added-user.csv');
    }

    public function exportUserDetailsOnyRegistraion()
    {
        $this->checkUser();
        $users = UserExportResource::collection(User::orderByDesc('created_at')->doesntHave('cart')->doesntHave('booking')->with(['cart'])->get(['email', 'name', 'phone']));
        return Excel::download(new UserExport($users), 'only-registration-user.csv');
    }

    public function cancelledBookingUser()
    {
        $this->checkUser();
        $users = UserExportResource::collection(User::whereHas('bookingCanceled')->get(['email', 'name', 'phone']));
        return Excel::download(new UserExport($users), 'cancelled-booking-user.csv');
    }
}
