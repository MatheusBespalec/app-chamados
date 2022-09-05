<?php

namespace App\Http\Middleware;

use App\Models\Whitelist as ModelsWhitelist;
use Closure;
use Illuminate\Http\Request;

class Whitelist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = ModelsWhitelist::query()->where('ip', $request->ip())->first();
        if (is_null($ip)) {
            return response(status: 401);
        }

        return $next($request);
    }
}
