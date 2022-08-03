<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Bot;
use App\Models\BotContract;
use App\Models\BotTiming;
use App\Models\Extension;
use App\Models\GeneralSetting;
use App\Models\MLM;
use App\Models\MLMBV;
use App\Models\MLMPlan;
use App\Models\Pairs;
use App\Models\Platform;
use App\Models\ThirdpartyProvider;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BotController extends Controller
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
    public function index()
    {
        $page_title = 'Bot Trader';
        $product = Extension::where('id', 1)->first();
        if (is_file(realpath(__DIR__) . '/Admin/Ext/' . $product->product_id . '.lic')) {
            return view('user.bot.bot-chart', compact('page_title'));
        } else {
            abort(406);
        }
    }

    public function fetch_info()
    {
        $user = Auth::user();
        $bot_contracts = BotContract::where('user_id', $user->id)->latest()->get();
        $bot_contracts_count = BotContract::where('user_id', $user->id)->get();
        $profit = $bot_contracts_count->where('result', 1)->sum('profit');
        $currency = getCurrency();

        return response()->json([
            'user' => $user,
            'bot_contracts' => $bot_contracts,
            'bot_contracts_count_running' => $bot_contracts_count->where('status', '!=', 1)->count(),
            'bot_contracts_count_completed' => $bot_contracts_count->where('status', 1)->count(),
            'bot_contracts_count_amount' => $bot_contracts_count->sum('amount'),
            'profit' => $profit,
            'currency' => $currency,
        ]);
    }

    public function fetch_bot(Request $request)
    {
        $user = Auth::user();
        if (isWallet($user->id, 'funding', $request->currency, 'funding') == true) {
            $wallet = getWallet($user->id, 'funding', $request->currency, 'funding');
        } else {
            $wallet = null;
        }
        if (BotContract::where('user_id', $user->id)->where('symbol', $request->symbol)->where('status', '!=', '1')->exists()) {
            $runningBot = BotContract::where('user_id', $user->id)->where('symbol', $request->symbol)->where('status', '!=', '1')->first();
        } else {
            $runningBot = null;
        }
        if ($this->provider == 'coinbasepro') {
            $provide = 'COINBASE';
        } else if ($this->provider != 'coinbasepro' && $this->provider != null) {
            $provide = strtoupper($this->provider);
            $provider = $this->provider;
        } else {
            $provide = 'KUCOIN';
            $provider = 'kucoin';
        }
        return response()->json([
            'user' => $user,
            'wallet' => $wallet,
            'bot_timing' => BotTiming::where('status', 1)->get(),
            'bot_type' => Bot::where('status', 1)->get(),
            'runningBot' => $runningBot,
            'limit' => json_decode(getGen()->limits),
            'provider' => $this->provider,
            'provide' => $provide,
            'pairs' => Pairs::where('provider', $this->provider)->where('status', 1)->pluck('symbol'),
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
            'botTime' => 'required|exists:bot_timings,duration',
            'bot_id' => 'required|exists:bots,id',
        ]);

        if ($validate->fails()) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Please select bot and time duration.'
                ]
            );
        }
        $user = Auth::user();
        $wallet = getWallet($user->id, 'funding', $request->currency, 'funding');
        $bot = Bot::where('id', $request->bot_id)->first();
        $general = GeneralSetting::first();
        if ($request->amount > $wallet->balance) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Your Account Balance ' . getAmount($wallet->balance) . ' ' . $general->cur_text . ' Not Enough! Please Deposit Money'
                ]
            );
        }
        $wallet->balance -= $request->amount;
        $wallet->save();

        $bot_contract = new BotContract();
        $bot_contract->user_id = $user->id;
        $bot_contract->bot_id = $request->bot_id;
        $bot_contract->bot_name = $bot->title;
        $bot_contract->symbol = $request->symbol;
        $bot_contract->pair = $request->currency;
        $bot_contract->amount = $request->amount;
        $bot_contract->min_profit = $bot->min_profit;
        $bot_contract->max_profit = $bot->max_profit;
        $bot_contract->status = '0';
        $bot_contract->start_price = getCoinRate($request->symbol);
        if ($request->type == "Min") {
            $time = Carbon::now()->addMinutes($request->botTime);
            $duration = $request->botTime * 60;
        } elseif ($request->type == "Hour") {
            $time = Carbon::now()->addHours($request->botTime);
            $duration = $request->botTime * 60 * 60;
        } elseif ($request->type == "Day") {
            $time = Carbon::now()->addDays($request->botTime);
            $duration = $request->botTime * 60 * 60 * 24;
        }

        $bot_contract->duration = $duration;
        $bot_contract->start_date = Carbon::now();
        $bot_contract->end_date = $time;
        $bot_contract->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New bot subscription from ' . $user->username;
        $adminNotification->click_url = route('admin.bot.log.pending');
        $adminNotification->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $bot_contract->amount;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type = "-";
        $transaction->details = 'Bot contract on ' . $request->symbol . $request->currency;
        $transaction->trx = getTrx();
        $transaction->save();

        if (Extension::where('id', 3)->first()->status == 1) {
            if ($user->ref_by != null) {
                $ref = User::where('id', $user->ref_by)->first();
                $refMLM = MLM::where('username', $ref->username)->first();
                $plan = MLMPlan::where('status', 1)->where('rank', $refMLM->rank)->first();
                $bonus = getCoinRate($request->currency) * $request->amount * $plan->bot_commission;
                $bvLog = new MLMBV();
                $bvLog->user_id = $ref->id;
                $bvLog->type = '5';
                $bvLog->amount = $bonus;
                $bvLog->save();
            }
        }

        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'message' => 'Your Contract Started Successfully'
            ]
        );
    }
}
