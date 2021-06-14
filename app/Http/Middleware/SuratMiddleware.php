<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuratMiddleware
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
        if(Auth()->user()->roles == "operator_surat"){
            return $next($request);
        }
        abort(404);
        
    }
}
