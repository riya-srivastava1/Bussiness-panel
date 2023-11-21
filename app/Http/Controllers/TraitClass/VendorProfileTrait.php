<?php

namespace App\Http\Controllers\TraitClass;

use App\VendorDocument;
use App\VendorProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait VendorProfileTrait
{
    use FileUploadTrait;

    public function saveBankInfo($vendorDocument, $request)
    {
        $vendorDocument->pan_no = $request->pan_no;
        $vendorDocument->gst_no = $request->gst_no;
        $vendorDocument->bank_name = $request->bank_name;
        $vendorDocument->branch_name = $request->branch_name;
        $vendorDocument->account_no = $request->account_no;
        $vendorDocument->account_holder = $request->account_holder;
        $vendorDocument->ifsc = $request->ifsc;
        $vendorDocument->kyc = $request->kyc;
        return $vendorDocument->save();
    }

    public function fileUploadBanner($request)
    {
        $this->validate($request, [
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = 'zoylee/uploads/business/banners/';
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $getData = VendorProfile::where('vendor_id', $vendor_id)->first();
        if ($getData != null && $getData->count() > 0) {
            if ($file = $request->file('banner')) {
                $old_img = $getData->banner;
                if ($this->doFileUpload($path, $file)) {
                    $getData->banner =  $request->file('banner')->hashName();
                }
                $l = strpos($old_img, '.');
                if ($l > 0) {
                    $unlinkPath = "zoylee/$old_img";
                    $this->doFileUnlink($unlinkPath);
                }
            }
            if ($getData->save()) {
                return back()->with('success', 'Banner Profile Updated');
            } else {
                return back()->with('success', 'Please try again later');
            }
        }
    }

    public function fileUploadLogo($request)
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500|dimensions:max_width=100,max_height=200',
        ]);
        $path = 'zoylee/uploads/business/logo/';
        $vendor = Auth::guard('business')->user();
        $vendor_id = $vendor->vendor_id;
        $getData = VendorProfile::where('vendor_id', $vendor_id)->first();
        if ($getData != null && $getData->count() > 0) {
            if ($file = $request->file('logo')) {
                $old_logo = $getData->logo;
                if ($this->doFileUpload($path, $file)) {
                    $getData->logo =  $request->file('logo')->hashName();
                }
                $l = strpos($old_logo, '.');
                if ($l > 0) {
                    $unlinkPath = "zoylee/$old_logo";
                    $this->doFileUnlink($unlinkPath);
                }
            }
            if ($getData->save()) {
                return back()->with('success', 'LOGO Updated');
            } else {
                return back()->with('success', 'Please try again later');
            }
        }
        return back()->with('info', "Please Registred Your Profile");
    }

    public function fileUploadPan($request)
    {
        $this->validate($request, [
            'pan_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000|dimensions:max_width=500,max_height=500',
        ]);
        $path = 'zoylee/uploads/business/pan/';
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $getData = VendorDocument::where('vendor_id', $vendor_id)->first();
        if ($getData != null && $getData->count() > 0) {
            if ($file = $request->file('pan_image')) {
                $old_pan = $getData->pan_image;
                if ($this->doFileUpload($path, $file)) {
                    $getData->pan_image =  $request->file('pan_image')->hashName();
                }
                $l = strpos($old_pan, '.');
                if ($l > 0) {
                    $unlinkPath = "zoylee/$old_pan";
                    $this->doFileUnlink($unlinkPath);
                }
            }
            if ($getData->save()) {
                return back()->with('success', 'PAN Updated');
            } else {
                return back()->with('success', 'Please try again later');
            }
        }
    }

    public function fileUploadBusinessCertificate($request)
    {
        $this->validate($request, [
            'business_certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:20000',
        ]);
        $path = 'zoylee/uploads/business/business_certificate/';
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $getData = VendorDocument::where('vendor_id', $vendor_id)->first();
        if ($getData != null && $getData->count() > 0) {
            if ($file = $request->file('business_certificate_image')) {
                $old_business_certificate_image = $getData->business_certificate_image;
                if ($this->doFileUpload($path, $file)) {
                    $getData->business_certificate_image =  $request->file('business_certificate_image')->hashName();
                }
                $l = strpos($old_business_certificate_image, '.');
                if ($l > 0) {
                    $unlinkPath = "zoylee/$old_business_certificate_image";
                    $this->doFileUnlink($unlinkPath);
                }
            }
            if ($getData->save()) {
                return back()->with('success', 'Your Business Certificate Updated');
            } else {
                return back()->with('success', 'Please try again later');
            }
        }
        return back()->with('info', "Please Registred Your Profile");
    }
}
