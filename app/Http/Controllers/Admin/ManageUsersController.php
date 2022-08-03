<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\BotContract;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Commission;
use App\Models\ExchangeLogs;
use App\Models\Extension;
use App\Models\ForexAccounts;
use App\Models\ForexLogs;
use App\Models\IcoLogs;
use App\Models\MLMBV;
use App\Models\Withdrawal;
use App\Models\TradeLog;
use App\Models\PracticeLog;
use App\Models\StakingLog;
use App\Models\ThirdpartyOrders;
use App\Models\ThirdpartyProvider;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use App\Notifications\BalanceAdmin;
use App\Notifications\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Throwable;

class ManageUsersController extends Controller
{
    public $provider = null;
    public function __construct()
    {
        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $this->provider = $thirdparty->title;
        }
    }
    public function allUsers()
    {
        $page_title = 'Manage Users';
        $empty_message = 'No user found';
        $users = User::latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function activeUsers()
    {
        $page_title = 'Manage Active Users';
        $empty_message = 'No active user found';
        $users = User::active()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function bannedUsers()
    {
        $page_title = 'Banned Users';
        $empty_message = 'No banned user found';
        $users = User::banned()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function emailUnverifiedUsers()
    {
        $page_title = 'Email Unverified Users';
        $empty_message = 'No email unverified user found';
        $users = User::emailUnverified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }
    public function emailVerifiedUsers()
    {
        $page_title = 'Email Verified Users';
        $empty_message = 'No email verified user found';
        $users = User::emailVerified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $users = User::where(function ($user) use ($search) {
            $user->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $users = $users->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $users = $users->where('status', 0);
                break;
            case 'emailUnverified':
                $page_title .= 'Email Unerified ';
                $users = $users->whereNull('email_verified_at');
                break;
        }
        $users = $users->paginate(getPaginate());
        $page_title .= 'User Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.users.list', compact('page_title', 'search', 'scope', 'empty_message', 'users'));
    }


    public function detail($id)
    {
        $page_title = 'User Detail';
        $user = User::findOrFail($id);
        $totalDeposit = Deposit::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $refer_by = User::where('id', $user->ref_by)->first();
        $totalWithdraw = Withdrawal::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $totalTransaction = Transaction::where('user_id', $user->id)->count();
        $practiceLogCount = PracticeLog::where('user_id', $user->id)->count();
        $tradeLog['traded'] = TradeLog::where('user_id', $user->id)->count();
        $tradeLog['wining'] = TradeLog::where('user_id', $user->id)->where('result', 1)->where('status', 1)->count();
        $tradeLog['losing'] = TradeLog::where('user_id', $user->id)->where('result', 2)->where('status', 1)->count();
        $tradeLog['draw'] = TradeLog::where('user_id', $user->id)->where('result', 3)->where('status', 1)->count();
        $wallets = Wallet::where('user_id', $user->id)->get();
        if ($this->provider != null) {
            $wallet_type = 'trading';
        } else {
            $wallet_type = 'funding';
        }
        return view('admin.users.detail', compact('page_title', 'user', 'totalDeposit', 'wallet_type', 'totalWithdraw', 'totalTransaction', 'wallets', 'tradeLog', 'practiceLogCount', 'refer_by'));
    }


    public function referralLog($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Referral Log : ' . $user->username;
        $empty_message = 'No Referral User Found';
        $users  = User::where('ref_by', $id)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function commissionLog($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Commission Log: ' . $user->username;
        $empty_message = 'No commission data found';
        $commissions = Commission::where('user_id', $id)->latest()->paginate(getPaginate());
        return view('admin.reports.commission', compact('page_title', 'empty_message', 'commissions'));
    }

    public function practiceLog($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Practice Trade Log : ' . $user->username;
        $empty_message = 'No Data Found';
        $practiceLogs = PracticeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs'));
    }
    public function traded($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Trade Log : ' . $user->username;
        $empty_message = 'No Data Found';
        $tradelogs = TradeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }
    public function wining($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Wining Trade Log : ' . $user->username;
        $empty_message = 'No Data Found';
        $tradelogs = TradeLog::where('user_id', $user->id)->where('result', 1)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }
    public function losing($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Losing Trade Log : ' . $user->username;
        $empty_message = 'No Data Found';
        $tradelogs = TradeLog::where('user_id', $user->id)->where('result', 2)->where('status',)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }
    public function draw($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Draw Trade Log : ' . $user->username;
        $empty_message = 'No Data Found';
        $tradelogs = TradeLog::where('user_id', $user->id)->where('result', 3)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'email' => 'required|email|max:160|unique:users,email,' . $user->id,
        ]);

        if ($request->email != $user->email && User::whereEmail($request->email)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }
        if ($request->mobile != $user->mobile && User::where('mobile', $request->mobile)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Phone number already exists.'];
            return back()->withNotify($notify);
        }
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $request->merge(['role_id' => isset($request->role_id) ? 1 : 3]);
        $request->merge(['email_verified_at' => isset($request->email_verified_at) ? 1 : 0]);

        $user->mobile = $request->mobile;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country = $request->country;
        $user->status = $request->status;
        $user->role_id = $request->role_id;
        if ($request->email_verified_at == 1) {
            $user->email_verified_at = $user->updated_at;
        } else {
            $user->email_verified_at = null;
        }
        $user->save();

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|gt:0']);

        $user = User::findOrFail($id);
        $amount = getAmount($request->amount);
        $general = GeneralSetting::first(['cur_text', 'cur_sym']);
        $wallet = Wallet::where('user_id', $user->id)->where('address', $request->address)->where('symbol', $request->symbol)->first();
        $trx = getTrx();

        if ($request->act) {

            $wallet->balance += $amount;
            $wallet->save();
            $notify[] = ['success', $general->cur_sym . $amount . ' has been added to ' . $wallet->symbol . ' balance'];
            if ($user) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = $amount;
                $transaction->post_balance = getAmount($wallet->balance);
                $transaction->charge = 0;
                $transaction->trx_type = '+';
                $transaction->details = 'Added Balance Via Admin';
                $transaction->trx =  $trx;
                $transaction->save();
                try {
                    $transaction->user->notify(new BalanceAdmin($transaction, 'add'));
                    $notify[] = ['success', 'Client Notified By Email Successfully'];
                } catch (Throwable $e) {
                    $notify[] = ['warning', 'Mail Not Properly Set'];
                }
            }
        } else {
            if ($amount > $wallet->balance) {
                $notify[] = ['error', $user->username . ' has insufficient balance.'];
                return back()->withNotify($notify);
            }

            $wallet->balance -= $amount;
            $wallet->save();
            $notify[] = ['success', $general->cur_sym . $amount . ' has been subtracted from ' . $user->username . ' balance'];
            if ($user) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = $amount;
                $transaction->post_balance = getAmount($wallet->balance);
                $transaction->charge = 0;
                $transaction->trx_type = '-';
                $transaction->details = 'Subtract Balance Via Admin';
                $transaction->trx =  $trx;
                $transaction->save();
                try {
                    $transaction->user->notify(new BalanceAdmin($transaction, 'subtracted'));
                    $notify[] = ['success', 'Client Notified By Email Successfully'];
                } catch (Throwable $e) {
                    $notify[] = ['warning', 'Mail Not Properly Set'];
                }
            }
        }
        return back()->withNotify($notify);
    }


    public function userLoginHistory($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Login History - ' . $user->username;
        $empty_message = 'No users login found.';
        $login_logs = $user->login_logs()->latest()->paginate(getPaginate());
        return view('admin.users.logins', compact('page_title', 'empty_message', 'login_logs'));
    }



    public function showEmailSingleForm($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Send Email To: ' . $user->username;
        return view('admin.users.email_single', compact('page_title', 'user'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $user = User::findOrFail($id);
        $subject = $request->subject;
        $message = $request->message;
        try {
            $user->notify(new SendMail($user, $subject, $message));
            $notify[] = ['success', $user->username . ' will receive an email shortly.'];
        } catch (Throwable $e) {
            $notify[] = ['warning', 'Mail Not Properly Set'];
        }

        return back()->withNotify($notify);
    }

    public function transactions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Transactions : ' . $user->username;
            $transactions = $user->transactions()->where('trx', $search)->with('user')->latest()->paginate(getPaginate());
            $empty_message = 'No transactions';
            return view('admin.reports.transactions', compact('page_title', 'search', 'user', 'transactions', 'empty_message'));
        }
        $page_title = 'User Transactions : ' . $user->username;
        $transactions = $user->transactions()->with('user')->latest()->paginate(getPaginate());
        $empty_message = 'No transactions';
        return view('admin.reports.transactions', compact('page_title', 'user', 'transactions', 'empty_message'));
    }

    public function deposits(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userId = $user->id;
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Deposits : ' . $user->username;
            $deposits = $user->deposits()->where('trx', $search)->latest()->paginate(getPaginate());
            $empty_message = 'No deposits';
            return view('admin.deposit.log', compact('page_title', 'search', 'user', 'deposits', 'empty_message', 'userId'));
        }

        $page_title = 'User Deposit : ' . $user->username;
        $deposits = $user->deposits()->latest()->paginate(getPaginate());
        $empty_message = 'No deposits';
        $scope = 'all';
        return view('admin.deposit.log', compact('page_title', 'user', 'deposits', 'empty_message', 'userId', 'scope'));
    }


    public function depViaMethod($method, $type = null, $userId)
    {
        $method = Gateway::where('alias', $method)->firstOrFail();
        $user = User::findOrFail($userId);
        if ($type == 'approved') {
            $page_title = 'Approved Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 1)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 3)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'successful') {
            $page_title = 'Successful Payment Via ' . $method->name;
            $deposits = Deposit::where('status', 1)->where('user_id', $user->id)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'pending') {
            $page_title = 'Pending Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 2)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } else {
            $page_title = 'Payment Via ' . $method->name;
            $deposits = Deposit::where('status', '!=', 0)->where('user_id', $user->id)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }
        $page_title = 'Deposit History: ' . $user->username . ' Via ' . $method->name;
        $methodAlias = $method->alias;
        $empty_message = 'Deposit Log';
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'methodAlias', 'userId'));
    }



    public function withdrawals(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Withdrawals : ' . $user->username;
            $withdrawals = $user->withdrawals()->where('trx', 'like', "%$search%")->latest()->paginate(getPaginate());
            $empty_message = 'No withdrawals';
            return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'search', 'withdrawals', 'empty_message'));
        }
        $page_title = 'User Withdrawals : ' . $user->username;
        $withdrawals = $user->withdrawals()->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawals';
        $userId = $user->id;
        return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'withdrawals', 'empty_message', 'userId'));
    }

    public  function withdrawalsViaMethod($method, $type, $userId)
    {
        $method = WithdrawMethod::findOrFail($method);
        $user = User::findOrFail($userId);
        if ($type == 'approved') {
            $page_title = 'Approved Withdrawal of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 1)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 3)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'pending') {
            $page_title = 'Pending Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 2)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'method'));
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Users';
        return view('admin.users.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (User::where('status', 1)->cursor() as $user) {
            $subject = $request->subject;
            $message = $request->message;
            try {
                $user->notify(new SendMail($user, $subject, $message));
            } catch (Throwable $e) {
                $notify[] = ['warning', 'Mail Not Properly Set'];
            }
        }

        $notify[] = ['success', 'All users will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $user = User::findOrFail($request->id);
        if (file_exists(public_path('data/practice/u00' . $user->id . '.json'))) {
            File::delete(public_path('data/practice/u00' . $user->id . '.json'));
        }
        if (file_exists(public_path('data/trade/u00' . $user->id . '.json'))) {
            File::delete(public_path('data/trade/u00' . $user->id . '.json'));
        }
        $practice_logs = PracticeLog::where('user_id', $request->id)->get();
        foreach ($practice_logs as $log) {
            $log->delete();
        }
        $deposits = Deposit::where('user_id', $request->id)->get();
        foreach ($deposits as $deposit) {
            $deposit->delete();
        }
        $withdrawals = Withdrawal::where('user_id', $request->id)->get();
        foreach ($withdrawals as $withdrawal) {
            $withdrawal->delete();
        }
        $trade_logs = TradeLog::where('user_id', $request->id)->get();
        foreach ($trade_logs as $log) {
            $log->delete();
        }
        $exchanges_logs = ExchangeLogs::where('user_id', $request->id)->get();
        foreach ($exchanges_logs as $log) {
            $log->delete();
        }
        $wallets = Wallet::where('user_id', $request->id)->get();
        foreach ($wallets as $wallet) {
            $wallet->delete();
        }
        $wallets_trx = WalletsTransactions::where('user_id', $request->id)->get();
        foreach ($wallets_trx as $trx) {
            $trx->delete();
        }
        $trxs = Transaction::where('user_id', $request->id)->get();
        foreach ($trxs as $trx) {
            $trx->delete();
        }
        $thirdtrxs = ThirdpartyOrders::where('user_id', $request->id)->get();
        foreach ($thirdtrxs as $thirdtrx) {
            $thirdtrx->delete();
        }
        if (Extension::where('id', 1)->first()->installed == 1) {
            if (BotContract::where('user_id', $request->id)->exists()) {
                $bot_logs = BotContract::where('user_id', $request->id)->get();
                foreach ($bot_logs as $log) {
                    $log->delete();
                }
            }
        }
        if (Extension::where('id', 2)->first()->installed == 1) {
            if (IcoLogs::where('user_id', $request->id)->exists()) {
                $ico_logs = IcoLogs::where('user_id', $request->id)->get();
                foreach ($ico_logs as $log) {
                    $log->delete();
                }
            }
        }
        if (Extension::where('id', 3)->first()->installed == 1) {
            if (MLMBV::where('user_id', $request->id)->exists()) {
                $mlm_logs = MLMBV::where('user_id', $request->id)->get();
                foreach ($mlm_logs as $log) {
                    $log->delete();
                }
            }
        }
        if (Extension::where('id', 4)->first()->installed == 1) {
            if (ForexAccounts::where('user_id', $request->id)->exists()) {
                $forexAccount = ForexAccounts::where('user_id', $request->id)->first();
                $forexAccount->delete();
            }
            $forex_logs = ForexLogs::where('user_id', $request->id)->get();
            foreach ($forex_logs as $log) {
                $log->delete();
            }
        }
        if (Extension::where('id', 6)->first()->installed == 1) {
            if (StakingLog::where('user_id', $request->id)->exists()) {
                $staking_logs = StakingLog::where('user_id', $request->id)->get();
                foreach ($staking_logs as $log) {
                    $log->delete();
                }
            }
        }

        $user->delete();

        $notify[] = ['success', 'Bot has been removed'];
        return back()->withNotify($notify);
    }
}
