<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class system_auth
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
        if (Auth::check() && Auth::user()->status == 'System') {
            return $next($request);
        }else {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied. Contact IT Department');
            abort(403);
        }
    }
}
