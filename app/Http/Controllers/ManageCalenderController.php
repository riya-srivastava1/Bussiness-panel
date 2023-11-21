<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\VendorLogEvent;
use App\Models\ManageCalendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageCalenderController extends Controller
{
    public function store(Request $request)
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $data = $request->all();
        $data['vendor_id'] = $vendor_id;
        if (ManageCalendar::create($data)) {
            //Generate log----------------------
            $msg = 'Vendor add booking limit in date =  '.$data['date'].' time = '.$data['time'].'limit = '.$data['limit'];
            $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //end generate log----------------------
            return back()->with('success', "Added");
        }
        Session::flash('info', "failed");
        return back();
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $date = $data['date'];
        $time = $data['time'];
        $getData = ManageCalendar::where('vendor_id', $vendor_id)->where('date', $date)->where('time', $time)->first();
        if ($getData->update($data)) {
            //Generate log----------------------
            $msg = 'Vendor add booking limit update =  '.$data['date'].' time = '.$data['time'];
            $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //end generate log----------------------
            return back()->with('success', "updated");
        }
        Session::flash('info', "failed");
        return back();
    }
}
