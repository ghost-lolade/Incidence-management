<?php

namespace App\Http\Middleware;

use Closure;

class LaboratoryMiddleware
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
        if ($request->user() && $request->user()->usertype != 'lab')
        {
            return new Response(view('unauthorized')->with('role', 'Laboratory Department'));
        }
        return $next($request);
    }
}
