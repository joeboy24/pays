<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Company;
use Session;
use Auth;

class load_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $company = Company::find(1);
        Session::put('company', $company);
        if (Auth::check()) {
            // }else {
            if (session('temp_pass')) {
                if (session('temp_pass') == auth()->user()->temp_pass) {
                    return $next($request);
                } else {
                    return redirect('/otp-verification');
                }
                return redirect('/passed');
            } else {
                Session::put('temp_pass', 'null');
                Session::put('phold', '');
                Session::put('otp_sms_count', 0);
                Session::put('otp_try_count', 0);
                Session::put('check_otp_redirect', '');
                return redirect('/');
            }
        }
    }
}
