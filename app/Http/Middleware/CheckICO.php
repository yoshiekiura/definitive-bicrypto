<?php

namespace App\Http\Middleware;

use App\Models\Extension;
use Closure;

class CheckICO
{
    public function handle($request, Closure $next)
    {
        if(Extension::where('id',2)->exists()) {
            $ico = Extension::where('id',2)->first();
            if($ico->status == 1){
                if(!is_file(base_path('app/Http/Controllers/Admin/Ext/'.$ico->product_id.'.lic'))){
                    abort(406);
                }
            }
        }

        return $next($request);
    }
}
