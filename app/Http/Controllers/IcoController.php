<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Extension;
use App\Models\ICO;
use App\Models\IcoLogs;
use App\Models\Transaction;
use App\Models\UserMeta;
use App\Models\Wallet;
use App\Models\MLM;
use App\Models\MLMBV;
use App\Models\MLMPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IcoController extends Controller
{

    public function fetch_info()
    {
        $user = Auth::user();
        $icos = ICO::get();
        if (UserMeta::where('user_id', $user->id)->exists()) {
            $meta = UserMeta::where('user_id', $user->id)->first();
        } else {
            $meta = 'Not Added Yet';
        }
        if (Wallet::where('user_id', $user->id)->where('type', 'funding')->exists()) {
            $wallets = Wallet::where('user_id', $user->id)->where('type', 'funding')->get();
        } else {
            $wallets = null;
        }
        if (IcoLogs::where('user_id', $user->id)->exists()) {
            $ico_logs = IcoLogs::where('user_id', $user->id)->latest()->get();
            $ico_balance = IcoLogs::where('user_id', $user->id)->where('status', 1)->sum('amount');
        } else {
            $ico_logs = null;
            $ico_balance = '0';
        }
        $currency = getCurrency();
        return response()->json([
            'user' => $user,
            'icos' => $icos,
            'meta' => $meta,
            'wallets' => $wallets,
            'ico_logs' => $ico_logs,
            'ico_balance' => $ico_balance,
            'currency' => $currency,
        ]);
    }

    public function fetch_ico_info($symbol)
    {
        $user = Auth::user();
        $ico = ICO::where('symbol', $symbol)->first();
        if (Wallet::where('user_id', $user->id)->where('symbol', $ico->network_symbol)->where('type', 'funding')->exists()) {
            $balance = Wallet::where('user_id', $user->id)->where('symbol', $ico->network_symbol)->where('type', 'funding')->first()->balance;
        } else {
            $balance = null;
        }
        if (UserMeta::where('user_id', $user->id)->exists()) {
            $meta = UserMeta::where('user_id', $user->id)->first();
        } else {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->save();
        }
        return response()->json([
            'user' => $user,
            'ico' => $ico,
            'rec_wallet' => $meta->rec_wallet,
            'balance' => $balance
        ]);
    }

    public function store_rec_wallet(Request $request)
    {
        $user = Auth::user();
        $meta = UserMeta::where('user_id', $user->id)->first();
        $meta->rec_wallet = $request->rec_wallet;
        $meta->network_symbol = $request->network_symbol;
        $meta->save();

        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'message' => 'Recieving Wallet Updated Successfuly'
            ]
        );
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'ico_id' => 'required|exists:icos,id',
            'symbol' => 'required|exists:wallets,symbol',
        ]);

        if ($validate->fails()) {
            $notify[] = ['warning', 'Some Missing Data, Please Try Again.'];
            return back()->withNotify($notify);
        }
        $user = Auth::user();
        $wallet = getWallet($user->id, 'funding', $request->symbol, 'funding');
        $ico = ICO::where('id', $request->ico_id)->first();
        if ($request->cost > $wallet->balance) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Your Account Balance ' . getAmount($wallet->balance) . ' ' . $wallet->symbol . ' Not Enough! Please Deposit Money'
                ]
            );
        }
        $wallet->balance -= $request->cost;
        $wallet->save();

        $ico_log = new IcoLogs();
        $ico_log->user_id = $user->id;
        $ico_log->ico_id = $request->ico_id;
        $ico_log->network_symbol = $wallet->symbol;
        $ico_log->rec_wallet = $request->rec_wallet;
        $ico_log->amount = $request->amount;
        $ico_log->cost = $request->cost;
        if ($ico->stage == 1) {
            $ico_log->amount = $request->amount;
        } else if ($ico->stage == 2) {
            $ico_log->amount = $request->amount;
        }
        $ico_log->status = 0;

        if ($ico->stage == 1) {
            $ico->soft_raised += $ico_log->amount;
        } else if ($ico->stage == 2) {
            $ico->hard_raised += $ico_log->amount;
        }
        $ico_log->save();
        $ico->owner_recieved += $request->cost;
        $ico->contributors++;
        $ico->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New ICO Token Purchase from ' . $user->username;
        $adminNotification->click_url = route('admin.ico.log.pending');
        $adminNotification->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $request->cost;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type = "-";
        $transaction->details = $request->ico_symbol . ' Token Purchase';
        $transaction->trx = getTrx();
        $transaction->save();

        if (Extension::where('id', 3)->first()->status == 1) {
            if ($user->ref_by != null) {
                $ref = User::where('id', $user->ref_by)->first();
                $refMLM = MLM::where('username', $ref->username)->first();
                $plan = MLMPlan::where('status', 1)->where('rank', $refMLM->rank)->first();
                $bonus = getCoinRate($wallet->symbol) * $request->amount * $plan->ico_commission;
                $bvLog = new MLMBV();
                $bvLog->user_id = $ref->id;
                $bvLog->type = '6';
                $bvLog->amount = $bonus;
                $bvLog->save();
            }
        }

        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'message' => 'Token Ordered Successfully'
            ]
        );
    }
}
