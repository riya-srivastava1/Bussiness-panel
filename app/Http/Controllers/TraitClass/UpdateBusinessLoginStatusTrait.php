<?php
namespace App\Http\Controllers\TraitClass;

use App\BusinessLoginStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait UpdateBusinessLoginStatusTrait {

    public function updateStatus($business){
        $businessLogin = BusinessLoginStatus::where('vendor_id',$business->vendor_id)->first();
        if(!$businessLogin){
            $businessLogin = new BusinessLoginStatus();
            $businessLogin->vendor_id = $business->vendor_id;
        }
        $businessLogin->business_session_id = session()->getId();
        $businessLogin->save();
    }

}
