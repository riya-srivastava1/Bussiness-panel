<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthBranchMiddleware
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
        if (Auth::guard('business')->check() && Auth::guard('business')->user()->label!=1) {
            return redirect()->route('business.dashboard');
        }
        return $next($request);
    }
}
