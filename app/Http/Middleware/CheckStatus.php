<?php

namespace App\Http\Middleware;

use Closure;
class CheckStatus
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
        if(auth()->user()->status == 1){
            if (auth()->user()->email_verified_at == NULL) {
                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : redirect()->route('verify');
            }
            return $next($request);
        } else{
            return  redirect()->route('banned');
        }
    }
}
