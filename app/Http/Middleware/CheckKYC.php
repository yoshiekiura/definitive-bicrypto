<?php

namespace App\Http\Middleware;

use App\Models\KYC;
use App\Models\Platform;
use Closure;
use Exception;
use Request;
use Illuminate\Support\Facades\Auth;

class CheckKYC
{
    public function handle($request, Closure $next)
    {
        if (Platform::where('option', 'kyc')->exists()) {
            $platform['kyc'] = json_decode(Platform::where('option', 'kyc')->first()->settings);
            $platform = arrayToObject($platform);
            if ($platform->kyc->kyc_status == 1) {
                if (KYC::where('userId', Auth::user()->id)->exists()) {
                    $status = KYC::where('userId', Auth::user()->id)->first();
                    if ($status->status != 'approved') {
                        if (Request::is('user/deposit**', 'user/withdraw**')) {
                            $notify[] = ['warning', 'Verify your identify first!'];
                            return $request->expectsJson()
                                ? abort(403, 'Your Identity is not verified.')
                                : redirect()->route('user.kyc')->withNotify($notify);
                        } else {
                            throw new Exception('nokyc');
                        }
                    }
                } else {
                    if (Request::is('user/deposit**', 'user/withdraw**')) {
                        $notify[] = ['warning', 'Verify your identify first!'];
                        return $request->expectsJson()
                            ? abort(403, 'Your Identity is not verified.')
                            : redirect()->route('user.kyc')->withNotify($notify);
                    } else {
                        throw new Exception('nokyc');
                    }
                }
            }
        }

        return $next($request);
    }
}
