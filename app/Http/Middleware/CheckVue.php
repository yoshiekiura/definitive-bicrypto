<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;

class CheckVue
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
        if (GeneralSetting::where('id',1)->first()->staging != 1) {
            return $next($request);
        } else {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'warning',
                    'message' => 'You cannot place real orders on staging'
                ]
            );
        }
    }
}
