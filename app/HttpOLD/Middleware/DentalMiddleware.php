<?php

namespace App\Http\Middleware;

use Closure;

class DentalMiddleware
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
        if ($request->user() && $request->user()->usertype != 'dental')
        {
            return new Response(view('unauthorized')->with('role', 'Dental Department'));
        }
        return $next($request);


    }
}
