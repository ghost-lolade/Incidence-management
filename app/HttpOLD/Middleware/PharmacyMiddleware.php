<?php

namespace App\Http\Middleware;

use Closure;

class PharmacyMiddleware
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
        if ($request->user() && $request->user()->usertype != 'pharm')
        {
            return new Response(view('unauthorized')->with('role', 'Dispensary Department'));
        }
        return $next($request);
    }
}
