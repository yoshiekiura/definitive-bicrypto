<?php

namespace App\Http\Controllers;

use App\Models\Pairs;
use App\Models\PracticeLog;
use App\Models\ThirdpartyProvider;
use App\Models\TradeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinaryController extends Controller
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
            ));
            $this->provider = $thirdparty->title;
        } else {
            $this->provider = null;
        }
        #$this->api->set_sandbox_mode('enable');
    }
    public function practice()
    {
        if ($this->provider == 'coinbasepro') {
            $provide = 'COINBASE';
        } else if ($this->provider == 'kucoin') {
            $provide = 'KUCOIN';
        } else {
            $provide = 'KUCOIN';
        }
        return response()->json([
            'user' => Auth::user(),
            'limit' => json_decode(getGen()->limits),
            'provider' => $this->provider,
            'provide' => $provide,
            'pairs' => Pairs::where('provider', $this->provider)->where('status', 1)->pluck('symbol'),
        ]);
    }

    public function trade($symbol, $currency)
    {
        if ($this->provider == 'coinbasepro') {
            $provide = 'COINBASE';
        } else if ($this->provider == 'kucoin') {
            $provide = 'KUCOIN';
        } else {
            $provide = 'KUCOIN';
        }
        return response()->json([
            'user' => Auth::user(),
            'limit' => json_decode(getGen()->limits),
            'provider' => $this->provider,
            'provide' => $provide,
            'pairs' => Pairs::where('provider', $this->provider)->where('status', 1)->pluck('symbol'),
        ]);
    }


    public function fetch_wallet(Request $request)
    {
        $user = Auth::user();
        if (isWallet($user->id, 'funding', $request->currency, 'funding') == true) {
            $wallet = getWallet($user->id, 'funding', $request->currency, 'funding')->balance;
        } else {
            $wallet = null;
        }

        return response()->json([
            'wallet' => $wallet,
        ]);;
    }

    public function binary_practice_log()
    {
        $user = Auth::user();
        $contracts = PracticeLog::where('user_id', $user->id)->get();
        if (!file_exists(public_path('data/practice/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/practice/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/practice/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return response()->json([
            'contracts' => $contracts,
            'datas' => $datas,
            'user' => $user,
        ]);
    }

    public function binary_practice_orders()
    {
        $user = Auth::user();
        $orders = PracticeLog::where('user_id', $user->id)->latest()->get();
        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function binary_trade_log()
    {
        $user = Auth::user();
        $contracts = TradeLog::where('user_id', $user->id)->get();
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return response()->json([
            'contracts' => $contracts,
            'datas' => $datas,
            'user' => $user,
        ]);
    }

    public function binary_trade_orders()
    {
        $user = Auth::user();
        $orders = TradeLog::where('user_id', $user->id)->latest()->get();
        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function preview($type, $id)
    {
        $user = Auth::user();
        if ($type == 'trade') {
            $contract = TradeLog::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        } else {
            $contract = PracticeLog::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        }
        if (!file_exists(public_path('data/' . $type . '/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/' . $type . '/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/' . $type . '/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        $data = $datas[$user->id][$id];
        $duration = Carbon::parse($contract->in_time)
            ->addSeconds($contract->duration)
            ->format('Y-m-d H:i:s');
        return response()->json([
            'contract' => $contract,
            'data' => $data,
            'duration' => $duration,
        ]);
    }
}
