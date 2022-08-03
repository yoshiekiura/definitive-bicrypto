<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDemo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role_id == 3) {
            $notify[] = ['warning', 'You are demo user'];
            return  back()->withNotify($notify);
        } else {
            return $next($request);
        }
    }
}
