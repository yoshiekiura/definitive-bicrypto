<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Providers\ProviderInstallController;
use App\Http\Controllers\Controller;
use App\Models\BinanceCurrencies;
use App\Models\BybitCurrencies;
use App\Models\CoinbaseCurrencies;
use App\Models\KucoinCurrencies;
use App\Models\Pairs;
use App\Models\ThirdpartyProvider;
use Illuminate\Http\Request;
use Throwable;

class ManageThirdpartyController extends Controller
{
    public function __construct()
    {
        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            $this->api = new $exchange_class(array(
                'apiKey' => $thirdparty->api,
                'secret' => $thirdparty->secret,
                'password' => $thirdparty->password,
                'options' => array(
                    'adjustForTimeDifference' => True
                ),
            ));
            $this->provider = $thirdparty->title;
        } else {
            $this->provider = null;
        }
        #$this->api->set_sandbox_mode('enable');
    }

    public function index()
    {
        $page_title = 'Providers';
        $providers = ThirdpartyProvider::latest()->get();
        $empty_message = 'No Provider Available';
        if ($this->provider != null) {
            try {
                $this->api->fetch_balance();
                $connection = "1";
            } catch (Throwable $e) {
                $connection = "0";
            }
        } else {
            $connection = "2";
        }
        $api = new ProviderInstallController;
        return view('admin.provider.index', compact('page_title', 'providers', 'empty_message', 'connection', 'api'));
    }

    public function edit($id)
    {
        $provider = ThirdpartyProvider::where('id', $id)->first();
        $page_title = $provider->title . ' Editor';
        if ($this->provider != null) {
            $api = $this->api;
        } else {
            $api = null;
        }
        return view('admin.provider.edit', compact('page_title', 'provider', 'api'));
    }

    public function balances($id)
    {
        $provider = ThirdpartyProvider::where('id', $id)->first();
        $page_title = $provider->title . ' Balances';
        $empty_message = 'No Balance Yet';
        if ($this->provider != null) {
            $api = $this->api;
            if ($this->provider == 'coinbasepro') {
                $currencies = $api->fetch_balance()['info'];
                $symbol = 'currency';
                $free = 'balance';
                $used = 'hold';
            } else if ($this->provider == 'binance') {
                $currencies = $api->fetch_balance()['info']['balances'];
                $symbol = 'asset';
                $free = 'free';
                $used = 'locked';
            } else if ($this->provider == 'kucoin') {
                $currencies = $api->fetch_balance()['info']['data'];
                $symbol = 'currency';
                $free = 'available';
                $used = 'holds';
            } else if ($this->provider == 'bybit') {
                $currencies = $api->fetch_balance()['info']['result'];
                $symbol = 'currency';
                $free = 'available_balance';
                $used = 'used_margin';
            }
        } else {
            $api = null;
        }
        //dd($currencies);
        return view('admin.provider.balance', compact('page_title', 'provider', 'currencies', 'api', 'symbol', 'free', 'used', 'empty_message'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api' => 'required',
            'secret' => 'required',
        ]);

        $provider = ThirdpartyProvider::findOrFail($request->id);
        $provider->api = $request->api;
        $provider->secret = $request->secret;
        $provider->password = $request->password;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $provider->status = $request->status;
        $provider->save();

        $notify[] = ['success', 'Provider has been Updated'];
        return back()->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $provider = ThirdpartyProvider::where('id', $request->id)->first();
        if ($this->provider != null) {
            if ($provider->status != 1) {
                $active = ThirdpartyProvider::where('status', 1)->first();
                $active->status = 0;
                $active->save();
            }
        }
        $provider->status = 1;
        $provider->save();
        $this->refresh();
        $notify[] = ['success', $provider->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $provider = ThirdpartyProvider::where('id', $request->id)->first();
        $provider->status = 0;
        $provider->save();
        $notify[] = ['success', $provider->name . ' has been deactivated'];
        return back()->withNotify($notify);
    }



    public function currencies($id)
    {
        $page_title = 'Currencies';
        $provider = ThirdpartyProvider::where('id', $id)->first()->title;
        if ($provider == 'kucoin') {
            $currencies = KucoinCurrencies::get();
        } else if ($provider == 'coinbasepro') {
            $currencies = CoinbaseCurrencies::get();
        } else if ($provider == 'bybit') {
            $currencies = BybitCurrencies::get();
        } else if ($provider == 'binance') {
            $currencies = BinanceCurrencies::get();
        }
        $empty_message = 'No Currency Available';
        return view('admin.provider.currencies', compact('page_title', 'currencies', 'empty_message', 'id'));
    }

    public function cur_activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $provider = ThirdpartyProvider::where('id', $request->provider_id)->first();
        if ($provider->title == 'kucoin') {
            $currency = KucoinCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'coinbasepro') {
            $currency = CoinbaseCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'bybit') {
            $currency = BybitCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'binance') {
            $currency = BinanceCurrencies::where('id', $request->id)->first();
        }
        $currency->status = 1;
        $currency->save();
        $notify[] = ['success', $currency->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function cur_deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $provider = ThirdpartyProvider::where('id', $request->provider_id)->first();
        if ($provider->title == 'kucoin') {
            $currency = KucoinCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'coinbasepro') {
            $currency = CoinbaseCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'bybit') {
            $currency = BybitCurrencies::where('id', $request->id)->first();
        } else if ($provider->title == 'binance') {
            $currency = BinanceCurrencies::where('id', $request->id)->first();
        }
        $currency->status = 0;
        $currency->save();
        $notify[] = ['success', $currency->name . ' has been deactivated'];
        return back()->withNotify($notify);
    }

    public function markets($id)
    {
        $page_title = 'Markets';
        $provider = ThirdpartyProvider::where('id', $id)->first()->title;
        $jsonString = file_get_contents(public_path('data/markets/markets.json'));
        $datas = json_decode($jsonString, true);
        $markets = arrayToObject($datas[$provider]);
        $empty_message = 'No Markets Available';
        return view('admin.provider.markets', compact('page_title', 'markets', 'empty_message', 'id'));
    }


    public function market_activate(Request $request)
    {
        $provider = ThirdpartyProvider::where('id', $request->provider_id)->first()->title;
        $jsonString = file_get_contents(public_path('data/markets/markets.json'));
        $datas = json_decode($jsonString, true);
        $datas[$provider][getPair($request->symbol)[1]][$request->symbol]['status'] = 1;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data/markets/markets.json'), stripslashes($newJsonString));
        $notify[] = ['success', ' has been activated'];
        return back()->withNotify($notify);
    }

    public function market_deactivate(Request $request)
    {
        $provider = ThirdpartyProvider::where('id', $request->provider_id)->first()->title;
        $jsonString = file_get_contents(public_path('data/markets/markets.json'));
        $datas = json_decode($jsonString, true);
        $datas[$provider][getPair($request->symbol)[1]][$request->symbol]['status'] = 0;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data/markets/markets.json'), stripslashes($newJsonString));
        $notify[] = ['success', ' has been deactivated'];
        return back()->withNotify($notify);
    }

    public function refresh()
    {
        $curl2 = curl_init(route('provider.currenciesToTable'));
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl2);
        $curl1 = curl_init(route('provider.currencies'));
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl1);
        $curl3 = curl_init(route('provider.marketsToTable'));
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl3);
        $curl4 = curl_init(route('provider.pairsToTable'));
        curl_setopt($curl4, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl4);
        $notify[] = ['success', 'Provider Markets Refreshed Successfully'];
        return back()->withNotify($notify);
    }
}
