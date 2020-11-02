<?php

namespace App\Http\Middleware;

use Closure;

class HelpdeskMiddleware
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
        if ($request->user() && $request->user()->usertype != 'helpdesk')
        {
            return new Response(view('unauthorized')->with('role', 'Helpdesk Department'));
        }
        return $next($request);
    }
}
