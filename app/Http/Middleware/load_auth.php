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
        // if (Auth::check()) {
        // }else {
            $company = Company::find(1);
            // $newsblog = 5;
            Session::put('company', $company);
            // Session::put('event', $event);
            return $next($request);
            // return redirect('/uiuytyu');
        // }
    }
}
