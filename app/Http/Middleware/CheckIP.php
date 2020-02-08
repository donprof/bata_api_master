<?php

namespace App\Http\Middleware;

use Closure;

class CheckIP
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
        if (str_contains($request->ip(), ['41.84.154','41.215.48','197.248.182','159.203.179','40.127.5','10.10.20','196.201.214','41.90.11'])) {
            return $next($request);
        }

        \Log::info($request->ip().' is not allowed to access the administration panel');

        // return $next($request);

        return abort(404);
    }
}
