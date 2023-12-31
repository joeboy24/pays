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

        // Session::put('error', '');
        $start = auth()->user()->otp_time;
        $end = date("Y-m-d h:i:s");
        $dt_diff = round((strtotime($end)-strtotime($start)) / 60, 2);
        // return $dt_diff;

        // Auth::logout();
        // Session::put('otp_sms_count', 2);
        // Session::put('otp_try_count', 2);
        // return 'SMS: '.session('otp_sms_count').'/ Try: '.session('otp_try_count').'/ Redirect: '.session('check_otp_redirect');

        // SMS // Try // Redirect
        $user = User::find(auth()->user()->id);

        if (session('otp_sms_count') >= 3) {
            $user->del = 'yes';
            $user->save();
        }
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
        }elseif (session('otp_sms_count') >= 3 && session('otp_try_count') >= 3) {
            if ($dt_diff >= 60) {
                return redirect('/otp-resend');
            }
            return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 1 hour');

        } elseif (session('otp_sms_count') >= 3 && session('otp_try_count') < 3) {
            if ($dt_diff >= 60) {
                return redirect('/otp-resend');
            }
            return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 1 hour..');

        } elseif (session('otp_sms_count') < 3 && session('otp_try_count') >= 3) {
            if ($dt_diff >= 10) {
                return redirect('/otp-resend');
            }
            return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 10 minutes..');

        } elseif (session('otp_sms_count') < 3 && session('otp_try_count') < 3) { // Thry OTP again
        }

        if (session('reset_status') == 'yes') {
            Session::put('check_otp_redirect', 1);
            Session::put('reset_status', 'no');
        } else {
            Session::put('check_otp_redirect', 2);
        }
        return view('auth.verify_otp');

        return 'Done';


        // if (session('otp_sms_count') >= 3) {
            //     // return 'Try > 3 & Sms < 60';
            //     if ($dt_diff >= 60) {
            //         Session::put('otp_sms_count', -1);
            //         return redirect('/otp-resend');
            //     }
            //     return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 1 hour');
            // }
            // if (session('otp_try_count') >= 3 && $dt_diff < 5) {
            //     return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 10 minutes..');
            // }
            // // return 'Pss';
            // $user = User::find(auth()->user()->id);
            // if (session('otp_sms_count') == 0) {
            //     // otp_sms_count = 0
            //     $temp_pass = rand(1000, 9999);
            //     Session::put('phold', $temp_pass);
            //     Session::put('check_otp_redirect', 1);
            //     $user->otp_time = date('Y-m-d h:i:s');
            //     $user->temp_pass = $temp_pass;
            //     $user->save();
            //     Session::put('otp_sms_count', session('otp_sms_count') + 1);
            //     return view('auth.verify_otp');
            //     // Send SMS and update count
            // }else{
            //     // If time up
            //     if (session('reset_status') == 'yes') {
            //         Session::put('check_otp_redirect', 1);
            //         Session::put('reset_status', 'no');
            //     } else {
            //         Session::put('check_otp_redirect', 2);
            //     }
            //     if (session('otp_try_count') >= 3) {
            //         if ($dt_diff >= 5) {
            //             return redirect('/otp-resend');
            //         }
            //         // Return account disabled page
            //         return view('auth.verify_otp_block');
            //     }
            //     // return 'klkjl';
            //     return view('auth.verify_otp');
        // }
    }
    
    public function account_blocked(){
        // If already logged in do nothing
        if (Auth::check() && auth()->user()->temp_pass == session('temp_pass')) {
            return redirect(url()->previous());
        }

        $start = auth()->user()->otp_time;
        $end = date("Y-m-d h:i:s");
        $dt_diff = round((strtotime($end)-strtotime($start)) / 60, 2);
        // return $dt_diff;
        if (auth()->user()->temp_pass == session('temp_pass')) {
            return redirect('/');
        }
        if ($dt_diff >= 60) {
            return redirect('/otp-verification');
        }
        return view('auth.verify_otp_block');
    }
    
    public function otp_pre_resend(){
        $temp_pass = rand(1000, 9999);
        Session::put('phold', $temp_pass);
        Session::put('check_otp_redirect', 1);
        $user->otp_time = date('Y-m-d h:i:s');
        $user->temp_pass = $temp_pass;
        $user->save();
        Session::put('otp_sms_count', session('otp_sms_count') + 1);
        // Session::put('otp_sms_count', 0);
        return redirect('/otp-verification')->with('warning', 'Input new OTP sent to '.substr(auth()->user()->contact, 0, 5).'*****');
    }
    
    public function resend_otp(){
        // If already logged in do nothing
        if (Auth::check() && auth()->user()->temp_pass == session('temp_pass')) {
            return redirect(url()->previous());
        }
    
        $user = User::find(auth()->user()->id);

        // Else
        if (session('otp_sms_count') >= 3) {
            // return 33;
            Session::put('otp_sms_count', 0);
        }else{
            // return 44;
            Session::put('otp_sms_count', session('otp_sms_count') + 1);
        }
        $temp_pass = rand(1000, 9999);
        $user->otp_time = date('Y-m-d h:i:s');
        $user->temp_pass = $temp_pass;
        $user->save();
        Session::put('temp_pass', 'null');
        Session::put('phold', '');
        Session::put('otp_try_count', 0);
        Session::put('phold', $temp_pass);
        Session::put('check_otp_redirect', 1);
        Session::put('reset_status', 'yes');
        // Session::put('check_otp_redirect', 1);
        return redirect('/otp-verification')->with('warning', 'Input new OTP sent to '.substr(auth()->user()->contact, 0, 5).'*****');
    }
}
