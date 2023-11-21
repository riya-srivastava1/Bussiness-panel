<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BusinessAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('business')->check()) {
            return redirect()->route('login');
        } if(Auth::guard('business')->check()){
            $expiresAt = now()->addMinutes(2);
            Cache::put('vendor-is-online-'.Auth::guard('business')->user()->vendor_id,true,$expiresAt);
            $user   = Auth::guard('business')->user();
            $status = $user->status;
            $step   = $user->step;
            if(!$status){
                if($step){
                    $sms = 'Please Complete Partner Form';
                    if(intval($step)==4){
                        return  redirect()->intended(route("step.{$step}"));
                    }
                    return redirect()->route("step.{$step}")->with("info",$sms);
                }
                return redirect()->route("step.1")->with("info",'Please Complete Partner Form');
            }
        }
        return $next($request);
    }
}
