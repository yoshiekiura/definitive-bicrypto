<?php

namespace App\Http\Middleware;

use App\Models\Extension;
use Closure;

class CheckBot
{
    public function handle($request, Closure $next)
    {
        if(Extension::where('id',1)->exists()) {
            $bot = Extension::where('id',1)->first();
            if($bot->status == 1){
                if(!is_file(base_path('app/Http/Controllers/Admin/Ext/'.$bot->product_id.'.lic'))){
                    abort(406);
                }
            }
        }

        return $next($request);
    }
}
