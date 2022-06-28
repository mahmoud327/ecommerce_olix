<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforceApiHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Accept', '*/*') === '*/*') {
            $request->headers->add(['Accept' => 'application/json']);
        }

        if (blank($request->header('Content-Type'))) {
            $request->headers->add(['Content-Type' => 'application/json']);
        }

        return $next($request);
    }
}
