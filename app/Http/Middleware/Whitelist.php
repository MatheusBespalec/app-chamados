<?php

namespace App\Http\Middleware;

use App\Models\Whitelist as ModelsWhitelist;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $ip = ModelsWhitelist::query()->where('ip', $request->ip())->notExpired()->first();
        if (is_null($ip)) {
            if (Auth::check()) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect(status: 401)->route('login');
        }

        return $next($request);
    }
}
