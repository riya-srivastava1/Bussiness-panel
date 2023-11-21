<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitClass\CreateSlugUrlTrait;
use App\Http\Controllers\TraitClass\VendorProfileTrait;
use App\models\VendorDocument;
use Illuminate\Http\Request;
use App\models\VendorProfile;
use Illuminate\Support\Facades\Validator;
use App\models\Business;
use App\Events\VendorLogEvent;
use App\Http\Controllers\TraitClass\NearByLocationTrait;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VendorProfileController extends Controller
{
    use CreateSlugUrlTrait;
    use VendorProfileTrait;
    use NearByLocationTrait;


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'banner' => ['required', 'mimes:PNG,png,jpg,JPG,JPEG,jpeg,gif,GIF', 'max:20000'],
        ]);
    }



    public function update(Request $request, $id)
    {
        $category_type = $request->category_type ? implode(',', $request->category_type) : null;
        $service_type = $request->service_type ? implode(',', $request->service_type) : null;
        $getData = VendorProfile::findOrFail($id);
        $data = $request->all();
        $data['working_day'] = $request->days;
        $data['category_type'] = $category_type;
        $data['service_type'] = $service_type;
        if ($getData->update($data)) {
            $getData->slug = $this->getSlugUrl($getData);
            $getData->save();
            //Generate log-------------------
            $msg = 'Vendor profile updated - ' . $getData->business_name;
            $eventData = ['vendor_id' => $getData->vendor_id, 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //end generate log-------------------

            Session::flash('active', 'profile');
            return back()->with('success', 'Profile Updated');
        }
        return back()->with("success", 'Profile Updated failed');
    }

    public function updateAddress(Request $request, $id)
    {
        $getData = VendorProfile::findOrFail($id);
        $data = $request->all();
        $near = ['type' => 'Point', 'coordinates' => [doubleval($request->lng), doubleval($request->lat)]];
        $data['near'] = $near;
        $data['map_place_id'] = $request->map_place_id;
        $this->updateNeraByLocation($request->city, $request->locality, $near);
        if ($getData->update($data)) {
            $getData->slug = $this->getSlugUrl($getData);
            $getData->save();
            Session::flash('active', 'profile');
            return redirect()->route('business.dashboard.myaccount', ["type" => 'address'])->with('success', 'Address Updated');
        }
        return back()->with("success", 'Address Updated failed');
    }

    public function updateBank(Request $request, $vendor_id)
    {
        $vendorDocument = VendorDocument::where('vendor_id', $vendor_id)->first();
        if (!$vendorDocument) {
            $vendorDocument = new VendorDocument();
        }
        $vendorDocument->vendor_id = $vendor_id;
        if ($this->saveBankInfo($vendorDocument, $request)) {
            Session::flash('active', 'profile');
            return redirect()->route('business.dashboard.myaccount', ["type" => 'bank'])->with('success', 'Bank Info Updated');
        }
        return back() > with("success", 'Bank Info Updated failed');
    }

    public function uploadBannerImage(Request $request)
    {
        return $this->fileUploadBanner($request);
    }
    public function uploadLogoImage(Request $request)
    {
        return $this->fileUploadLogo($request);
    }

    public  function uploadPanImage(Request $request)
    {
        return $this->fileUploadPan($request);
    }

    public  function uploadBusinessCertificateImage(Request $request)
    {
        return $this->fileUploadBusinessCertificate($request);
    }


    public function updateAmenity(Request $request, $id)
    {
        $data = $request->get('aminity');
        $arr = [];
        if ($data) {
            foreach ($data as $d) {
                $d = json_decode($d);
                $val = [
                    'name' => $d->name,
                    'icon' => $d->icon
                ];
                $arr = Arr::prepend($arr, $val);
            }
        }
        $vp = VendorProfile::where('vendor_id', $id)->first();
        $vp->amenity = json_encode($arr);
        if ($vp->update()) {
            $msg = 'Vendor amenity updated ';
            $eventData = ['vendor_id' => $vp->vendor_id, 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //End generate log-------------------

            return back()->with('success', 'Added');
        }
        return back()->with('info', 'Error');
    }


    public function storeBranch(Request $request)
    {
        $category_type = $request->category_type ? implode(',', $request->category_type) : null;
        $getData = $request->all();
        $request->validate([
            'owner_contact' => ['required', 'string', 'max:10', 'min:10'],
            'email' => ['required', 'string', 'min:6', 'max:255', 'unique:businesses'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'owner_name' => ['required'],
        ]);
        $label = 2;
        $business = Business::create([
            'vendor_id' => (time() * 1000) . trim($request['owner_contact']),
            'parent_id' => $request['parent_id'],
            'label' => $label,
            'owner_contact' => $request['owner_contact'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'show_password' => $request['password'],
            'notify_to' => $request->notify_to
        ]);
        try {
            $near =  ['type' => 'Point', 'coordinates' => [doubleval($request->lng), doubleval($request->lat)]];
            $getData['near'] = $near;
            $getData['map_place_id'] = $request->map_place_id;
            $this->updateNeraByLocation($request->city, $request->locality, $near);
            $getData['vendor_id'] = $business->vendor_id;
            $getData['category_type'] = $category_type;
            $getData['working_day'] = $request->days;
            VendorProfile::create($getData);
            //Generate log----------------------
            $msg = 'Add new branch ' . $request->get('business_name');
            $eventData = ['vendor_id' => $request['parent_id'], 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //End generate log-------------------
            return redirect()->route('vendor.branch')->with('success', "Branch Added");
        } catch (Exception $e) {
            report($e);
            $business->delete();
            Session::flash('info', 'Internal server error ! please try later');
        }
        return back();
    }

    public function branchLogin(Request $request)
    {
        Auth::guard('business')->logout();
        $test = ['email' => $request['email'], 'password' => $request['password']];
        Auth::guard('business')->attempt($test);
        Session::flash('success', $request['email'] . " login");
        return redirect()->intended('/dashboard');
    }
}
