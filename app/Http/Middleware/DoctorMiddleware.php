<?php

namespace App\Http\Middleware;

use Closure;

class DoctorMiddleware
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
        if ($request->user() && $request->user()->usertype != 'doctor')
        {
            return new Response(view('unauthorized')->with('role', 'Consulting Department'));
        }
        return $next($request);
    }
}
