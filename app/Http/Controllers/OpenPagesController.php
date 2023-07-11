<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Auth;

class OpenPagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth']);
    }  
    
    public function verify_otp(){
        // $to_time = strtotime("Y-m-d h:i:s", date("Y-m-d h:i:s"));
        // $from_time = strtotime("2023-07-11 01:43:00");
        // return round(abs($to_time - $from_time) / 60,2). " minute";

        $start = auth()->user()->otp_time;
        $end = date("Y-m-d h:i:s");
        $dt_diff = round((strtotime($end)-strtotime($start)) / 60, 2);
        // return $dt_diff;

        // Auth::logout();
        // Session::put('otp_try_count', 0);
        // Session::put('otp_sms_count', 0);
        // return 1;

        if (auth()->user()->temp_pass == session('temp_pass')) {
            Session::put('check_otp_redirect', 'verified');
            Session::put('otp_try_count', 0);
            Session::put('otp_sms_count', 0);
            return view('auth.verify_otp');
            return redirect('/');
        }
        if (session('otp_try_count') >= 3) {
            return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 5 minutes');
        }
        $user = User::find(auth()->user()->id);
        if (session('otp_sms_count') == 0) {
            $temp_pass = rand(1000, 9999);
            Session::put('phold', $temp_pass);
            Session::put('check_otp_redirect', 1);
            $user->otp_time = date('Y-m-d h:i:s');
            $user->temp_pass = $temp_pass;
            $user->save();
            Session::put('otp_sms_count', session('otp_sms_count') + 1);
            return view('auth.verify_otp');
            // Send SMS and update count
        }else{
            // If time up
            // otp_sms_count = 0
            $user->otp_time = date('Y-m-d h:i:s');
            $user->save();
            if (session('otp_try_count') >= 3) {
                if ($dt_diff >= 5) {
                    Session::put('otp_try_count', 0);
                    // Session::put('otp_sms_count', 0);
                    return redirect('/');
                }
                // Return account disabled page
                return view('auth.verify_otp_block');
            }
            return view('auth.verify_otp');
        }
    }
    
    public function account_blocked(){

        $start = auth()->user()->otp_time;
        $end = date("Y-m-d h:i:s");
        $dt_diff = round((strtotime($end)-strtotime($start)) / 60, 2);
        // return $dt_diff;
        if ($dt_diff >= 5) {
            Auth::logout();
            Session::put('otp_try_count', 0);
            // Session::put('otp_sms_count', 0);
            return redirect('/');
        }
        if (auth()->user()->temp_pass == session('temp_pass')) {
            return redirect('/');
        }
        return view('auth.verify_otp_block');
    }
}
