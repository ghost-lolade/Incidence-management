<?php

namespace App\Http\Middleware;

use Closure;

class NurseMiddleware
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
        if ($request->user() && $request->user()->usertype != 'nurse')
        {
            return new Response(view('unauthorized')->with('role', 'Nursing Department'));
        }
        return $next($request);
    }
}
