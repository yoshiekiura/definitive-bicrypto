<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (auth()->user()->id == 1 && auth()->user()->id == 3) {
                    return redirect()->intended(config('fortify.admin'));
                } else {
                    return redirect()->intended(config('fortify.home'));
                }
            }
        }

        return $next($request);
    }
}
