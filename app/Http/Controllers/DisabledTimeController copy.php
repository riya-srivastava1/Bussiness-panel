<?php

namespace App\Http\Controllers\Business;

use App\Models\DisabledTime;
use Illuminate\Http\Request;
use App\Events\VendorLogEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DisabledTimeController extends Controller
{
    public function disabledTime(Request $request){
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $data = $request->all();
        $data['vendor_id'] = $vendor_id;
        if (DisabledTime::create($data)) {
              //Generate log----------------------
              $msg = 'Vendor time <span class="badge badge-danger">disabled </span> '.$data['date'].' - '.$data['time'];
              $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
              event(new VendorLogEvent($eventData));
              //end generate log----------------------
            Session::flash('success', ' Disabled ');
            return back();
        }
        Session::flash('info', "failed");
        return back();
    }
    public function enableTime(Request $request)
    {
        $data = $request->all();
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $date = $data['date'];
        $time = $data['time'];
        $getData = DisabledTime::where('vendor_id', $vendor_id)->where('date', $date)->where('time', $time)->first();
        //Generate log----------------------
        $msg = 'Vendor time <span class="badge badge-success">Enabled </span> '.$data['date'].' - '.$data['time'];
        $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
        event(new VendorLogEvent($eventData));
        //end generate log----------------------
        if ($getData!=null && $getData->delete()) {
            Session::flash('success', ' Enabled ');
            return back();
        }
        Session::flash('info', "failed");
        return back();
    }
}
