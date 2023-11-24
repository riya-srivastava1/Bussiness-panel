<?php

namespace App\Http\Controllers\Business;

use Illuminate\Support\Str;
use App\Models\VendorSlider;
use Illuminate\Http\Request;
use App\Events\VendorLogEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TraitClass\FileUploadTrait;

class VendorSliderController extends Controller
{

    use FileUploadTrait;

    protected function validator(array $data)
    {
        // 'dimensions:min_height=280,max_height=320'
        return Validator::make($data, [
            'image' => ['required', 'max:20000', 'mimes:PNG,png,jpg,JPG,JPEG,jpeg'],
        ]);
    }

    public function sliders()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $sliders = VendorSlider::where('vendor_id', $vendor_id)->orderBy('created_at', 'DESC')->get();
        return view('dashboard.slider', compact(['sliders']));
    }

    public function store(Request $request)
    {
        $path =  'zoylee/uploads/business/sliders/';
        $validate = $this->validator($request->all());
        if ($validate->fails()) {
            Session::flash('active', 'slider');
            return  redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $count = VendorSlider::where('vendor_id', $vendor_id)->count();
        if ($count >= 5) {
            Session::flash('info', 'Max 5 Images Uploaded!');
            Session::flash('active', 'slider');
            return back();
        }
        $vendor_slider = new VendorSlider();
        $vendor_slider->vendor_id = $vendor_id;
        $vendor_slider->title = $request->title;
        if ($file = $request->file('image')) {
            if ($this->doFileUpload($path, $file)) {
                $vendor_slider->image =  $request->file('image')->hashName();
            }
        }
        if ($vendor_slider->save()) {
            //Generate log----------------------
            $msg = 'Vendor Slider added ';
            $eventData = ['vendor_id' => $vendor_id, 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //end generate log----------------------
            Session::flash('success', 'Slider Added');
            Session::flash('active', 'slider');
        } else {
            Session::flash('info', 'failed');
            Session::flash('active', 'slider');
        }
        return back();
    }

    public function destroy($id)
    {
        $image = VendorSlider::findOrFail($id);
        if ($image) {
            $l = strpos($image->image, '.');
            if ($l > 0) {
                $unlinkPath = "zoylee/$image->image";
                $this->doFileUnlink($unlinkPath);
            }

            //Generate log-------------
            $msg = 'Vendor Slider Deleted ';
            $eventData = ['vendor_id' => $image->vendor_id, 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //End Generate log-------------
            VendorSlider::destroy($id);
            //=========Activity Log

            Session::flash('success', ' Deleted');
            Session::flash('active', 'slider');
            return back();
        } else {
            Session::flash('info', ' No Record Found!');
            return back();
        }
    }
}
