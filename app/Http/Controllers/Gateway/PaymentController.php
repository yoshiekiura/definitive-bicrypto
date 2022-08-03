<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Commission;
use App\Models\MLM;
use App\Models\MLMBV;
use App\Models\MLMPlan;
use App\Models\Platform;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use App\Notifications\DepositNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Throwable;

class PaymentController extends Controller
{
    public function __construct()
    {
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $page_title = 'Deposit Methods';
        $track = session()->get('Track');
        return view('user.payment.deposit', compact('gatewayCurrency', 'page_title', 'track'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        $user = Auth::user();
        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please Follow Deposit Limit'];
            return back()->withNotify($notify);
        }

        $charge = getAmount($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));
        $payable = getAmount($request->amount + $charge);
        $final_amo = getAmount($payable * $gate->rate);

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = getAmount($final_amo);
        $data->address = $request->address;
        $data->symbol = $request->symbol;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();

        session()->put('Track', $data);
        return redirect()->route('user.deposit.preview');
    }


    public function depositPreview()
    {
        $track = session()->get('Track');
        $data = Deposit::where('trx', $track->trx)->orderBy('id', 'DESC')->firstOrFail();
        if (is_null($data)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        $page_title = 'Payment Preview';
        $address = $track->address;
        $symbol = $track->symbol;
        $plat = Platform::first();
        return view('user.payment.preview', compact('data', 'page_title', 'address', 'symbol', 'plat'));
    }


    public function depositConfirm()
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track->trx)->orderBy('id', 'DESC')->with('gateway')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $page_title = 'Payment Confirm';
        return view($data->view, compact('data', 'page_title', 'deposit'));
    }


    public static function userDataUpdate($trx)
    {
        $gnl = GeneralSetting::first();
        $plat = Platform::first();
        $data = Deposit::where('trx', $trx)->first();
        if ($data->status == 0) {
            $data->status = 1;
            $data->save();

            $user = User::find($data->user_id);
            $wallet = getWallet($data->user_id, 'funding', $data->symbol, 'funding');
            $wallet->balance += ($data->amount * $data->rate) / getCoinRate($data->symbol);
            $wallet->save();
            $gateway = $data->gateway;

            $transaction = new Transaction();
            $transaction->user_id = $data->user_id;
            $transaction->amount = $data->amount;
            $transaction->post_balance = getAmount($wallet->balance);
            $transaction->charge = getAmount($data->charge);
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via ' . $data->gateway_currency()->name . ' Into Your ' . $wallet->symbol . '';
            $transaction->trx = $data->trx;
            $transaction->save();
            try {
                $transaction->user->notify(new DepositNote($transaction, 'automated-deposit-successful'));
                $notify[] = ['success', 'Client Notified By Email Successfully'];
            } catch (Throwable $e) {
                $notify[] = ['warning', 'Mail Not Properly Set'];
            }

            $wallet_new_trx = new WalletsTransactions();
            $wallet_new_trx->user_id = $user->id;
            $wallet_new_trx->symbol = $data->symbol;
            $wallet_new_trx->address = $data->address;
            $wallet_new_trx->amount = ($data->amount * $data->rate) / getCoinRate($data->symbol);
            $wallet_new_trx->amount_recieved = ($data->amount * $data->rate) / getCoinRate($data->symbol);
            $wallet_new_trx->charge = ($data->charge * $data->rate) / getCoinRate($data->symbol);
            $wallet_new_trx->to = $data->address;
            $wallet_new_trx->type = '1';
            $wallet_new_trx->status = '1';
            $wallet_new_trx->trx = $data->trx;
            $wallet_new_trx->details = 'Deposited ' . ($data->amount * $data->rate) / getCoinRate($data->symbol) . ' To Wallet';
            $wallet_new_trx->wallet_type = 'funding';
            $wallet_new_trx->save();

            if ($plat->mlm == 1) {
                if ($user->ref_by != null) {
                    $ref = User::where('id', $user->ref_by)->first();
                    $refMLM = MLM::where('username', $ref->username)->first();
                    $plan = MLMPlan::where('status', 1)->where('rank', $refMLM->rank)->first();
                    $bonus = (($data->amount * $plan->deposit_commission) / 100);
                    $userMLM = MLM::where('username', $user->username)->first();
                    if ($userMLM->status == 1) {
                        $bvLog = new MLMBV();
                        $bvLog->user_id = $ref->id;
                        $bvLog->type = '1';
                        $bvLog->amount = $bonus;
                        $bvLog->save();
                    } else {
                        $bvLog = new MLMBV();
                        $bvLog->user_id = $ref->id;
                        if ($userMLM->rank == 0) {
                            if ($bonus >= $plan->ref_commission) {
                                $amount = $bonus;
                            } else {
                                $amount = $plan->ref_commission;
                            }
                            $bvLog->type = '2';
                        } else {
                            if ($bonus >= $plan->active_ref_commission) {
                                $amount = $bonus;
                            } else {
                                $amount = $plan->active_ref_commission;
                            }
                            $bvLog->type = '3';
                        }
                        $bvLog->amount = $amount;
                        $bvLog->save();

                        $userMLM->status = 1;
                        $userMLM->save();
                    }
                }
            } else if ($gnl->referal_status == 1 && $plat->mlm == 0) {
                if ($user->ref_by != null) {
                    $refer_by = User::where('id', $user->ref_by)->first();
                    $refer_wallet = Wallet::where('user_id', $user->ref_by)->where('type', 'funding')->where('symbol', 'USDT')->first();
                    if ($refer_wallet) {
                        $bonus = (($data->amount * $gnl->referral_bonus) / 100);
                        $refer_wallet->balance += $bonus;
                        $refer_wallet->save();

                        $commission = new Commission();
                        $commission->user_id = $refer_by->id;
                        $commission->from_user_id = $user->id;
                        $commission->amount = $bonus;
                        $commission->details = "Commission From " . $user->username . " for Deposit.";
                        $commission->post_balance = $refer_wallet->balance;
                        $commission->trx = getTrx();
                        $commission->save();

                        $transaction = new Transaction();
                        $transaction->user_id = $refer_by->id;
                        $transaction->amount = $bonus;
                        $transaction->post_balance = getAmount($refer_wallet->balance);
                        $transaction->trx_type = '+';
                        $transaction->details = 'Commission Via ' . $user->username . ' For Deposit';
                        $transaction->trx = getTrx();
                        $transaction->save();
                    }
                }
            }
            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Deposit successful via ' . $data->gateway_currency()->name;
            $adminNotification->click_url = route('admin.deposit.successful');
            $adminNotification->save();
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track->trx)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $page_title = 'Deposit Confirm';
            $method = $data->gateway_currency();
            return view('user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track->trx)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }


        $this->validate($request, $rules);


        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['deposit']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }



        $data->status = 2; // pending
        $data->save();
        if ($data->save()) {
            try {
                $data->user->notify(new DepositNote($data, 'manual-deposit-user-requested'));
                $notify[] = ['success', 'Client Notified By Email Successfully'];
            } catch (Throwable $e) {
                $notify[] = ['warning', 'Mail Not Properly Set'];
            }
        }


        $wallet_new_trx = new WalletsTransactions();
        $wallet_new_trx->user_id = $data->user_id;
        $wallet_new_trx->symbol = $data->symbol;
        $wallet_new_trx->address = $data->address;
        $wallet_new_trx->amount = ($data->amount * $data->rate) / getCoinRate($data->symbol);
        $wallet_new_trx->amount_recieved = ($data->amount * $data->rate) / getCoinRate($data->symbol);
        $wallet_new_trx->charge = ($data->charge * $data->rate) / getCoinRate($data->symbol);
        $wallet_new_trx->to = $data->address;
        $wallet_new_trx->type = '1';
        $wallet_new_trx->status = '2';
        $wallet_new_trx->trx = $data->trx;
        $wallet_new_trx->details = 'Deposited ' . ($data->amount * $data->rate) / getCoinRate($data->symbol) . ' To Wallet';
        $wallet_new_trx->wallet_type = 'funding';
        $wallet_new_trx->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from ' . $data->user->username;
        $adminNotification->click_url = route('admin.deposit.details', $data->id);
        $adminNotification->save();

        $notify[] = ['success', 'Your deposit request has been taken successfully.'];
        return redirect()->route('user.deposit.history')->withNotify($notify);
    }
}
