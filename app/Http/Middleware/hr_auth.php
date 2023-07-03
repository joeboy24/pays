<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class hr_auth
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
        if (Auth::check() && Auth::user()->status == 'HR') {
            return $next($request);
        }else {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied. Contact HR Administrator');
            abort(403);
        }
    }
}
