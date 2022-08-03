<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Platform;
use App\Models\SidebarMenu;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        $page_title = 'Platform Settings';
        $plats = Platform::get();
        foreach ($plats as $plat) {
            $platform[$plat->option] = json_decode($plat->settings);
        }
        $platform = arrayToObject($platform);
        return view('admin.setting.platform', compact('page_title', 'platform'));
    }

    public function update(Request $request)
    {
        $request->merge(['preloader' => isset($request->preloader) ? 1 : 0]);
        $request->merge(['sw' => isset($request->sw) ? 1 : 0]);
        $request->merge(['frontend_status' => isset($request->frontend_status) ? 1 : 0]);
        $request->merge(['binary_status' => isset($request->binary_status) ? 1 : 0]);
        $request->merge(['pair_prices' => isset($request->pair_prices) ? 1 : 0]);
        $request->merge(['practice' => isset($request->practice) ? 1 : 0]);
        $request->merge(['kyc_status' => isset($request->kyc_status) ? 1 : 0]);
        $request->merge(['data' => isset($request->data) ? 1 : 0]);
        $platform['frontend'] = Platform::where('option', 'frontend')->first();
        $platform['frontend']->settings = json_encode([
            'preloader' => $request->preloader,
            'frontend_status' => $request->frontend_status,
        ]);
        $platform['frontend']->save();
        $platform['trading'] = Platform::where('option', 'trading')->first();
        $platform['trading']->settings = json_encode([
            'binary_status' => $request->binary_status,
            'pair_prices' => $request->pair_prices,
            'practice' => $request->practice,
        ]);
        $platform['trading']->save();
        $sidebarbinary = SidebarMenu::where('id', 17)->first();
        $sidebarbinary->status = $request->binary_status;
        $sidebarbinary->Save();

        $platform['kyc'] = Platform::where('option', 'kyc')->first();
        $platform['kyc']->settings = json_encode([
            'kyc_status' => $request->kyc_status,
        ]);
        $platform['kyc']->save();

        $platform['system'] = Platform::where('option', 'system')->first();
        $platform['system']->settings = json_encode([
            'sw' => $request->sw,
        ]);
        $platform['system']->save();

        $sidebarKYC = SidebarMenu::where('id', 4)->first();
        $sidebarKYC->status = $request->kyc_status;
        $sidebarKYC->Save();

        $platform['bot'] = Platform::where('option', 'bot')->first();
        $platform['bot']->settings = json_encode([
            'data' => $request->data,
        ]);
        $platform['bot']->save();

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $notify[] = ['success', 'Platform Setting has been updated.'];
        return back()->withNotify($notify);
    }
}
