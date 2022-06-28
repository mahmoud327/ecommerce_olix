<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class lang
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
        $locale = ($request->hasHeader('x-localization')) ? $request->header('x-localization') : 'ar' ;

        app()->setlocale($locale);

        return $next($request);
    }
}
