<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\PracticeLog;
use App\Models\ScheduledOrders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PracticeController extends Controller
{
    public function btcRate(Request $request)
    {
        $cryptoRate = getCoinRate($request->coinSymbol);
        return $cryptoRate;
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
            'OrderType' => 'required|in:1,2'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $user = Auth::user();
        if ($request->amount > $user->practice_balance) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'value'         => 2,
                    'message' => 'Your Practice Balance ' . getAmount($user->practice_balance) . ' ' . $request->currency . ' Not Enough! Please Add Practice Amount'
                ]
            );
        }
        $user->practice_balance -= $request->amount;
        $user->save();
        if ($request->OrderType == 1) {
            $OrderTyp = 'Rise';
        } else {
            $OrderTyp = 'Fall';
        }
        $practiceLog = new PracticeLog();
        $practiceLog->user_id = $user->id;
        $practiceLog->symbol = $request->symbol;
        $practiceLog->pair = $request->currency;
        $practiceLog->amount = $request->amount;
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
        $practiceLog->duration = $duration;
        $practiceLog->in_time = $time;
        $practiceLog->hilow = $request->OrderType;
        $practiceLog->price_was = getCoinRate($request->symbol);
        $practiceLog->save();
        return response()->json(
            [
                'success' => true,
                'tradeLogId' => $practiceLog->id,
                'type' => 'success',
                'value'         => 1,
                'trade'     => $practiceLog->price_was,
            ]
        );
    }

    public function schedule(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);
        $user = Auth::user();
        if ($request->amount > $user->practice_balance) {
            $notify[] = ['warning', 'Your Practice Balance ' . getAmount($user->practice_balance) . ' ' . $request->pair . ' Not Enough! Please Add Practice Amount'];
        }
        $user->practice_balance -= $request->amount;
        $user->save();
        $practiceLog = new ScheduledOrders();
        $practiceLog->user_id = $user->id;
        $practiceLog->market = $request->market;
        $practiceLog->pair = $request->pair;
        $practiceLog->amount = $request->amount;
        $practiceLog->price = $request->price;
        if ($request->unit == "sec") {
            $practiceLog->duration = $request->duration;
            $practiceLog->in_time = Carbon::now()->addSeconds($request->duration);
        } elseif ($request->unit == "min") {
            $practiceLog->duration = $request->duration * 60;
            $practiceLog->in_time = Carbon::now()->addMinutes($request->duration);
        } elseif ($request->unit == "hour") {
            $practiceLog->duration = $request->duration * 60 * 60;
            $practiceLog->in_time = Carbon::now()->addHours($request->duration);
        }
        $practiceLog->account = $request->account;
        $practiceLog->type = $request->type;
        if ($request->price > $request->current) {
            $practiceLog->method = '1';
        } else {
            $practiceLog->method = '2';
        }
        $practiceLog->status = '0';
        $practiceLog->save();
        if ($practiceLog->save()) {
            $notify[] = ['success', 'Order Scheduled Successfully'];
        }
        return back()->withNotify($notify);
    }

    public function tradeResult(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tradeLogId' => 'required|exists:practice_logs,id'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $user = Auth::user();
        $practiceLog = PracticeLog::where('id', $request->tradeLogId)->where('user_id', $user->id)->firstOrFail();
        $gnl = GeneralSetting::first();
        $cryptoRate = getCoinRate($practiceLog->symbol);
        // Read File
        if (!file_exists(public_path('data/practice/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/practice/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/practice/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        // Update Key
        $datas[$user->id][$request->tradeLogId] = $request->obj;
        // Write File
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data/practice/u00' . $user->id . '.json'), stripslashes($newJsonString));
        if ($practiceLog->result == 0) {
            if ($practiceLog->hilow == 1) {
                if ($practiceLog->price_was < $cryptoRate) {
                    $user->practice_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $practiceLog->result = 1;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 1;
                } else if ($practiceLog->price_was > $cryptoRate) {
                    $practiceLog->result = 2;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 2;
                } else {
                    $user->practice_balance += $practiceLog->amount;
                    $user->save();

                    $practiceLog->result = 3;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 3;
                }
            } else if ($practiceLog->hilow == 2) {
                if ($practiceLog->price_was > $cryptoRate) {
                    $user->practice_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $practiceLog->result = 1;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 1;
                } else if ($practiceLog->price_was < $cryptoRate) {
                    $practiceLog->result = 2;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 2;
                } else {
                    $user->practice_balance += $practiceLog->amount;
                    $user->save();

                    $practiceLog->result = 3;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 3;
                }
            }
        }
    }

    public function practiceLog()
    {
        $user = Auth::user();
        $page_title = "Practice Trade History";
        $empty_message = "No Data Found";
        $contracts = PracticeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        if (!file_exists(public_path('data/practice/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/practice/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/practice/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        return view('user.contract.log', compact('page_title', 'empty_message', 'contracts', 'user', 'datas'));
    }

    public function practiceLogChart($tradeLogId)
    {
        $user = Auth::user();
        $page_title = "Practice Trade Preview";
        $empty_message = "No Data Found";
        $contract = PracticeLog::where('id', $tradeLogId)->where('user_id', $user->id)->firstOrFail();
        if (!file_exists(public_path('data/practice/u00' . $user->id . '.json'))) {
            $json_data = '{"' . $user->id . '": {"1": []}}';
            file_put_contents(public_path('data/practice/u00' . $user->id . '.json'), $json_data);
        }
        $jsonString = file_get_contents(public_path('data/practice/u00' . $user->id . '.json'));
        $datas = json_decode($jsonString, true);
        $data = $datas[$user->id][$tradeLogId];
        $duration = Carbon::parse($contract->in_time)
            ->addSeconds($contract->duration)
            ->format('Y-m-d H:i:s');
        $fee = GeneralSetting::first()->profit / 100;
        return view('user.contract.preview', compact('page_title', 'empty_message', 'contract', 'data', 'tradeLogId', 'duration', 'fee'));
    }
}
