<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class finance_auth
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
        if (Auth::check() && Auth::user()->status == 'Fiance' || Auth::user()->status == 'Administrator') {
            return $next($request);
        }else {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied. Contact Finance Administrator');
            abort(403);
        }
    }
}
