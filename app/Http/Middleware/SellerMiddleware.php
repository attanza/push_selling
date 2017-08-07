<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SellerMiddleware
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
        if (Auth::check()) {
            $role = Auth::user()->roles()->first()->slug;
            if ($role == 'seller' || $role == 'supervisor') {
                return $next($request);
            } else {
                return redirect('/dashboard')->withError('Oops ... Operation not allowed');
            }
        } else {
            return redirect('/login');
        }
    }
}
