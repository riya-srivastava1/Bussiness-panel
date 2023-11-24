<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use App\Models\VendorStylist;
use App\Events\VendorLogEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TraitClass\FileUploadTrait;

class VendorStylistController extends Controller
{

    use FileUploadTrait;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'image' =>['mimes:PNG,png,jpg,JPG,JPEG,jpeg','max:10000'],
        ]);
    }
    public function store(Request $request)
    {
        $path = 'zoylee/uploads/business/stylists/';
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $data  = $request->all();
        $data['vendor_id'] = $vendor_id;
        if ($file = $request->file('image')) {
            $this->validator($data)->validate();
            if ($this->doFileUpload($path, $file)) {
                $data['image'] =  $request->file('image')->hashName();
            }
        }
        if (VendorStylist::create($data)) {
            //Generate log----------------------
            $msg = 'Vendor stylist added '.$request->get('name');
            $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //End generate log------------------
            return back()->with("success", "Stylist Added");
        }
        return back()->with("info", "Wrong !!");
    }


    public function update(Request $request, $id)
    {

        $path = 'zoylee/uploads/business/stylists/';
        $getData = VendorStylist::findOrFail($id);
        $data = $request->all();
        if ($file = $request->file('image')) {
            $this->validator($data)->validate();
            if ($this->doFileUpload($path, $file)) {
                $data['image'] =  $request->file('image')->hashName();
            }
            $l = strpos($getData->image, '.');
            if ($l>0) {
                $unlinkPath = $path.$getData->image;
                $this->doFileUnlink($unlinkPath);
            }
        }
        if ($getData->update($data)) {
            //Generate log----------------------
            $msg = 'Vendor stylist Updated '.$request->get('name');
            $eventData = ['vendor_id'=>$getData->vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //End generate log----------------------
            return back()->with("success",'Stylist Updated');
        }
        return back()->with("success", 'Error! Please contact support team');
    }

    public function destroy($id)
    {
        $path = 'zoylee/uploads/business/stylists/';
        $image = VendorStylist::findOrFail($id);
        if ($image) {
            $l = strpos($image->image, '.');
            if ($l>0) {
                $unlinkPath = $path.$image->image;
                $this->doFileUnlink($unlinkPath);
            }
            //Generate log----------------------
            $msg = 'Vendor stylist Deleted '.$image->name;
            $eventData = ['vendor_id'=>$image->vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //End generate log-------------------
            VendorStylist::destroy($id);
            return back()->with('success', ' Deleted');
        } else {
            return back()->with('info', 'Error! Please contact support team');
        }
    }
}
