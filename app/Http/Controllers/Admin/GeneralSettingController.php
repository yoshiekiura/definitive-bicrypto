<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Currencies;
use App\Models\Extension;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $general = GeneralSetting::first();
        $limits = json_decode($general->limits);
        $page_title = 'Settings';
        $bot = Extension::where('id', 1)->first();
        $wal_connect = Extension::where('id', 7)->first();
        return view('admin.setting.general_setting', compact('page_title', 'general', 'limits', 'bot', 'wal_connect'));
    }

    public function currencies()
    {
        $page_title = 'Currencies';
        $currencies = Currencies::paginate(getPaginate(10));
        return view('admin.setting.currencies', compact('page_title', 'currencies'));
    }

    public function update(Request $request)
    {
        $validation_rule = [
            'exchange_fee' => ['numeric'],
            'trx_fee' => ['numeric'],
            'referral_bonus' => ['numeric'],
            'profit' => ['numeric'],
            'practice_balance' => ['numeric'],
        ];

        $validator = Validator::make($request->all(), $validation_rule, []);
        $validator->validate();

        $general_setting = GeneralSetting::first();
        $settings = Setting::get();
        $sitename = $settings->where('field', 'site_name')->first();
        $sitename->value = $request->sitename;
        $sitename->save();

        $request->merge(['force_ssl' => isset($request->force_ssl) ? 1 : 0]);
        $request->merge(['registration' => isset($request->registration) ? 1 : 0]);
        $request->merge(['referal_status' => isset($request->referal_status) ? 1 : 0]);
        $request->merge(['APP_DEBUG' => isset($request->APP_DEBUG) ? 'true' : 'false']);

        $general_setting->sitename = $request->sitename;
        $general_setting->cur_text = $request->cur_text;
        $general_setting->cur_sym = $request->cur_sym;
        $general_setting->force_ssl = $request->force_ssl;
        $general_setting->practice_balance = $request->practice_balance;
        $general_setting->practice_wallet = $request->practice_wallet;
        $general_setting->registration = $request->registration;
        $general_setting->profit = $request->profit;
        $general_setting->referral_bonus = $request->referral_bonus;
        $general_setting->referal_status = $request->referal_status;
        $general_setting->exchange_fee = $request->exchange_fee;
        $general_setting->trx_fee = $request->trx_fee;
        $general_setting->moralis_server_url = $request->moralis_server_url;
        $general_setting->moralis_app_id = $request->moralis_app_id;
        $general_setting->cors = $request->cors;
        $general_setting->limits = json_encode([
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'min_time_sec' => $request->min_time_sec,
            'max_time_sec' => $request->max_time_sec,
            'min_time_min' => $request->min_time_min,
            'max_time_min' => $request->max_time_min,
            'min_time_hour' => $request->min_time_hour,
            'max_time_hour' => $request->max_time_hour,
        ]);
        $general_setting->provider_withdraw_fee = $request->provider_withdraw_fee;
        changeEnv('APP_DEBUG', $request->input('APP_DEBUG', null));

        $general_setting->save();
        Artisan::call('optimize:clear');
        $notify[] = ['success', 'General Setting has been updated.'];
        return back()->withNotify($notify);
    }

    public function currency_update(Request $request)
    {
        $validation_rule = [
            'rate' => ['numeric'],
        ];

        $validator = Validator::make($request->all(), $validation_rule, []);
        $validator->validate();

        $cur = Currencies::where('id', $request->id)->first();

        $cur->rate = $request->rate;
        $cur->save();
        $notify[] = ['success', 'Currency Rate has been updated.'];
        return back()->withNotify($notify);
    }

    public function logoIcon()
    {
        $page_title = 'Logo & Icon';
        return view('admin.setting.logo_icon', compact('page_title'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'logo' => 'image|mimes:jpg,jpeg,png,svg',
            'favicon' => 'image|mimes:png',
        ]);
        if ($request->hasFile('logo')) {
            try {
                $path = imagePath()['logoIcon']['path'];
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Logo could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = imagePath()['logoIcon']['path'];
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', imagePath()['favicon']['size']);
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Favicon could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo Icons has been updated.'];
        return back()->withNotify($notify);
    }

    public function currency_activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $currency = Currencies::where('id', $request->id)->first();
        if ($currency->status != 1) {
            $active = Currencies::where('status', 1)->first();
            $active->status = 0;
            $active->save();
        }
        $currency->status = 1;
        $currency->save();
        $notify[] = ['success', $currency->name . ' has been activated'];
        return back()->withNotify($notify);
    }
}
