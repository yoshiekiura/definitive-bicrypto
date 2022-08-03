<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extension;
use App\Models\TradeLog;
use App\Models\Transaction;
use App\Models\GeneralSetting;
use App\Models\MLM;
use App\Models\MLMBV;
use App\Models\MLMPlan;
use App\Models\ScheduledOrders;
use App\Models\User;
use App\Models\Watchlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function btcRate(Request $request)
    {
        $cryptoRate = getCoinRate($request->coinSymbol);
        return $cryptoRate;
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'OrderType' => 'required|in:1,2'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $user = Auth::user();
        $wallet = getWallet($user->id, 'funding', $request->currency, 'funding');
        if ($request->amount > $wallet->balance) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'value'         => 2,
                    'message' => 'Your Account Balance ' . getAmount($wallet->balance) . ' ' . $wallet->symbol . ' Not Enough! Please Deposit First'
                ]
            );
        }
        $wallet->balance -= $request->amount;
        $wallet->save();
        if ($request->OrderType == 1) {
            $OrderTyp = 'High';
        } else {
            $OrderTyp = 'Low';
        }
        $tradeLog = new TradeLog();
        $tradeLog->user_id = $user->id;
        $tradeLog->symbol = $request->symbol;
        $tradeLog->pair = $request->currency;
        $tradeLog->amount = $request->amount;
        $tradeLog->margin = $request->amount * (GeneralSetting::first()->profit / 100);
        if ($request->unit == "Sec") {
            $time = Carbon::now()->addSeconds($request->duration);
            $duration = $request->duration;
        } elseif ($request->unit == "Min") {
            $time = Carbon::now()->addMinutes($request->duration);
            $duration = $request->duration * 60;
        } elseif ($request->unit == "Hour") {
            $time = Carbon::now()->addHours($request->duration);
            $duration = $request->duration * 60 * 60;
        }
        $tradeLog->duration = $duration;
        $tradeLog->in_time = $time;
        $tradeLog->hilow = $request->OrderType;
        $tradeLog->price_was = getCoinRate($request->symbol);
        $tradeLog->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $tradeLog->amount;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type = "-";
        $transaction->details = 'Trade ' . $request->symbol . ' ' . $OrderTyp;
        $transaction->trx = getTrx();
        $transaction->save();

        if (Extension::where('id', 3)->first()->status == 1) {
            if ($user->ref_by != null) {
                $ref = User::where('id', $user->ref_by)->first();
                $refMLM = MLM::where('username', $ref->username)->first();
                $plan = MLMPlan::where('status', 1)->where('rank', $refMLM->rank)->first();
                $bonus = getCoinRate($request->currency) * $tradeLog->amount * $plan->trade_commission;
                $bvLog = new MLMBV();
                $bvLog->user_id = $ref->id;
                $bvLog->type = '4';
                $bvLog->amount = $bonus;
                $bvLog->save();
            }
        }
        return response()->json(
            [
                'success' => true,
                'tradeLogId' => $tradeLog->id,
                'type' => 'success',
                'value'         => 1,
                'trade'     => $tradeLog->price_was,
            ]
        );
    }

    public function schedule(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'type' => 'required',
        ]);
        $user = Auth::user();
        $wallet = getWallet($user->id, 'funding', $request->currency, 'funding');

        $general = GeneralSetting::first();
        if ($request->amount > $wallet->balance) {
            $notify[] = ['warning', 'Your Account Balance ' . getAmount($wallet->balance) . ' ' . $wallet->symbol . ' Not Enough! Please Deposit Money'];
        }

        $wallet->balance -= $request->amount;
        $wallet->save();
        $tradeLog = new ScheduledOrders();
        $tradeLog->user_id = $user->id;
        $tradeLog->market = $request->market;
        $tradeLog->pair = $request->currency;
        $tradeLog->amount = $request->amount;
        $tradeLog->margin = $request->amount * ($general->profit / 100);
        $tradeLog->price = $request->price;
        if ($request->unit == "sec") {
            $tradeLog->duration = $request->duration;
            $tradeLog->in_time = Carbon::now()->addSeconds($request->duration);
        } elseif ($request->unit == "min") {
            $tradeLog->duration = $request->duration * 60;
            $tradeLog->in_time = Carbon::now()->addMinutes($request->duration);
        } elseif ($request->unit == "hour") {
            $tradeLog->duration = $request->duration * 60 * 60;
            $tradeLog->in_time = Carbon::now()->addHours($request->duration);
        }
        $tradeLog->account = $request->account;
        $tradeLog->type = $request->type;
        if ($request->price > $request->current) {
            $tradeLog->method = '1';
        } else {
            $tradeLog->method = '2';
        }
        $tradeLog->status = '0';
        $tradeLog->save();
        if ($tradeLog->save()) {
            $notify[] = ['success', 'Order Scheduled Successfully'];
        }
        return back()->withNotify($notify);
    }

    public function tradeResult(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tradeLogId' => 'required|exists:trade_logs,id'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $user = Auth::user();
        $wallet = getWallet($user->id, 'funding', $request->currency, 'funding');
        $gnl = GeneralSetting::first();
        $tradeLog = TradeLog::where('id', $request->tradeLogId)->where('user_id', $user->id)->firstOrFail();
        $cryptoRate = getCoinRate($tradeLog->symbol);
        // Read File
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        // Update Key
        $datas[$user->id][$request->tradeLogId] = $request->obj;
        // Write File
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), stripslashes($newJsonString));
        if ($tradeLog->result == 0) {
            if ($tradeLog->hilow == 1) {
                if ($tradeLog->price_was < $cryptoRate) {
                    $wallet->balance += $tradeLog->amount + $tradeLog->margin;
                    $wallet->save();

                    $details = "Trade " . $tradeLog->symbol . ' ' . "WIN";
                    $tradeLogAmount = $tradeLog->amount + $tradeLog->margin;
                    $this->transactions($wallet, $tradeLogAmount, $details);

                    $tradeLog->result = 1;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 1;
                } else if ($tradeLog->price_was > $cryptoRate) {
                    $tradeLog->result = 2;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 2;
                } else {
                    $wallet->balance += $tradeLog->amount;
                    $wallet->save();

                    $details = "Trade " . $tradeLog->symbol . ' ' .  "Refund";
                    $tradeLogAmount = $tradeLog->amount;
                    $this->transactions($wallet, $tradeLogAmount, $details);
                    $tradeLog->result = 3;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 3;
                }
            } else if ($tradeLog->hilow == 2) {
                if ($tradeLog->price_was > $cryptoRate) {
                    $wallet->balance += $tradeLog->amount + $tradeLog->margin;
                    $wallet->save();

                    $details = "Trade " . $tradeLog->symbol . ' ' . "WIN";
                    $tradeLogAmount = $tradeLog->amount + $tradeLog->margin;
                    $this->transactions($wallet, $tradeLogAmount, $details);

                    $tradeLog->result = 1;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 1;
                } else if ($tradeLog->price_was < $cryptoRate) {
                    $tradeLog->result = 2;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 2;
                } else {
                    $wallet->balance += $tradeLog->amount;
                    $wallet->save();

                    $details = "Trade " . $tradeLog->symbol . ' ' .  "Refund";
                    $tradeLogAmount = $tradeLog->amount;
                    $this->transactions($wallet, $tradeLogAmount, $details);

                    $tradeLog->result = 3;
                    $tradeLog->status = 1;
                    $tradeLog->save();
                    return 3;
                }
            }
        }
    }

    public function tradeContract()
    {
        $user = Auth::user();
        $page_title = "Trade History";
        $empty_message = "No Data Found";
        $contracts = TradeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return view('user.contract.log', compact('page_title', 'empty_message', 'contracts', 'user', 'datas'));
    }

    public function ContractChart($tradeLogId)
    {
        $user = Auth::user();
        $page_title = "Trade Preview";
        $empty_message = "No Data Found";
        $contract = TradeLog::where('id', $tradeLogId)->where('user_id', $user->id)->firstOrFail();
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        $data = $datas[$user->id][$tradeLogId];
        $duration = Carbon::parse($contract->in_time)
            ->addSeconds($contract->duration)
            ->format('Y-m-d H:i:s');
        $fee = GeneralSetting::first()->profit / 100;
        return view('user.contract.preview', compact('page_title', 'empty_message', 'contract', 'data', 'tradeLogId', 'duration', 'user', 'fee'));
    }

    public function winingTradeContract()
    {
        $user = Auth::user();

        $page_title = "Wining Trade History";
        $empty_message = "No Data Found";
        $contracts = TradeLog::where('user_id', $user->id)->where('result', 1)->latest()->paginate(getPaginate());
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return view('user.contract.log', compact('page_title', 'empty_message', 'contracts', 'user', 'datas'));
    }

    public function losingTradeContract()
    {
        $user = Auth::user();

        $page_title = "Losing Trade History";
        $empty_message = "No Data Found";
        $contracts = TradeLog::where('user_id', $user->id)->where('result', 2)->latest()->paginate(getPaginate());
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return view('user.contract.log', compact('page_title', 'empty_message', 'contracts', 'user', 'datas'));
    }

    public function drawTradeContract()
    {
        $user = Auth::user();

        $page_title = "Draw Trade History";
        $empty_message = "No Data Found";
        $contracts = TradeLog::where('user_id', $user->id)->where('result', 3)->latest()->paginate(getPaginate());
        if (!file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/trade/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/trade/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return view('user.contract.log', compact('page_title', 'empty_message', 'contracts', 'user', 'datas'));
    }

    private function transactions($wallet, $tradeLogAmount, $details)
    {
        $transaction = new Transaction();
        $transaction->user_id = $wallet->user_id;
        $transaction->amount = $tradeLogAmount;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type = "+";
        $transaction->details = $details;
        $transaction->trx = getTrx();
        $transaction->save();
    }
}
