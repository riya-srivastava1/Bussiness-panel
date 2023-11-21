<?php

namespace App\Http\Controllers;

use App\Models\VendorProfile;
use App\Models\DisabledDate;
use App\Models\DisabledTime;
use Illuminate\Http\Request;
use App\Events\VendorLogEvent;
use App\Models\ManageCalendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DisabledDateController extends Controller
{
    public function disabledDateFun(Request $request)
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $data = $request->all();
        $data['vendor_id'] = $vendor_id;
        if (DisabledDate::create($data)) {
            //Generate log----------------------
            $msg = 'Vendor date <span class="badge badge-danger">Disabled </span> '.$data['date'];
            $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
            event(new VendorLogEvent($eventData));
            //end generate log----------------------
            return back()->with('success', $data['date'].' disabled');
        }
        return back()->with('info', "Error ! Please Report our team");
    }

    public function enabledDateFun(Request $request)
    {
        $data = $request->all();
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $date = $data['date'];
        $getData = DisabledDate::where('vendor_id', $vendor_id)->where('date', $date)->first();
         //Generate log----------------------
         $msg = 'Vendor date <span class="badge badge-success">Enabled </span> '.$date;
         $eventData = ['vendor_id'=>$vendor_id,'data'=>$msg];
         event(new VendorLogEvent($eventData));
         //end generate log----------------------
        if ($getData->delete()) {
            return back()->with('success', $data['date'].' enabled');
        }
        return back()->with('info', "Error ! Please Report our team");
    }

    public function getTimeShedule(Request $request)
    {
        $times = "";
        $profileData = Auth::guard('business')->user();
        $vendor_id = $profileData->vendor_id;
        $data = $request->all();
        $getDisableTime = DisabledTime::where('vendor_id', $vendor_id)->where('date', $data['date'])->pluck('time');
        $getDisableTime = $getDisableTime->toArray();

        $getManageCalender = ManageCalendar::where('vendor_id', $vendor_id)->where('date', $data['date'])->pluck('time');
        $getManageCalender = $getManageCalender->toArray();

        $openTime = (int)$profileData->vendor_profile->opening_time;
        $closeTime = (int)$profileData->vendor_profile->closing_time;
        $diffTime = $closeTime-$openTime;
        $zeroCounter = 0;
        while ($zeroCounter<=$diffTime) {
            $currentTimeInHour = date('H');
            $currentTimeInHour = $currentTimeInHour+1;
            $disabled = '';
            // $timeBtnClass = 'border-default p-2 available w-100 bg-white';
            if(strtotime($data['date']) == strtotime(date('d-m-Y'))){
                if($openTime<=$currentTimeInHour){
                    $disabled = "disabled";
                    // $timeBtnClass = ' btn btn-secondary text-dark p-2  w-100 bg-white';
                }
            }
            $times .=  "
                        <button
                            data-target='#myModal'
                            data-toggle='modal'
                            type='button'
                            id='{$this->setLimitFun($openTime, $getManageCalender, $data['date'], $vendor_id)}'
                            value='{$openTime}'
                            class = '{$this->getDisableTimeFun($openTime, $getDisableTime, $getManageCalender)}'
                            {$disabled}
                          >
                         {$this->convertTime($openTime)}
                        </button>
                       ";

            $openTime+=1;
            $zeroCounter+=1;
        }

        print_r($times);
        // echo $getDisableTime->count();
    }
    public function convertTime($time)
    {
        if ($time>=12) {
            if ($time==12) {
                return "12:00 pm";
            } elseif ($time==24) {
                return "12:00 am";
            } else {
                return (($time-12).":00 pm");
            }
        } else {
            return $time.":00 am";
        }
    }
    public function getDisableTimeFun($openTime, $disableTime, $getManageCalender)
    {
        $var = 'btn timeButton';
        if (in_array($openTime, $getManageCalender)) {
            $var = "btn timeButton btn-limit-time";
            if (in_array($openTime, $disableTime)) {
                $var = "btn timeButton btn-disable-date-time ";
            }
            return $var;
        }
        if (in_array($openTime, $disableTime)) {
            $var = "btn timeButton btn-disable-date-time";
            return $var;
        }
        $var = "btn timeButton";
        return $var;
    }
    public function setLimitFun($openTime, $getManageCalender, $date, $vendor_id)
    {
        if (in_array($openTime, $getManageCalender)) {
            $openTime = ''.$openTime.'';
            $getLimitData = ManageCalendar::where('vendor_id', $vendor_id)->where('date', $date)->where('time', $openTime)->first();
            return $getLimitData->limit;
        }
        return '0';
    }
}
