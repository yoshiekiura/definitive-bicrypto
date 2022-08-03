<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForexAccounts;
use App\Models\ForexLogs;
use App\Models\ForexSignals;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ManageForexController extends Controller
{
    public function index()
    {
        $page_title = 'Forex Accounts';
        $accounts = ForexAccounts::latest()->paginate(getPaginate());
        $empty_message = 'No Account Found';
        return view('admin.forex.index', compact('page_title','accounts','empty_message'));
    }

    public function new()
    {
        $page_title = 'New Account';
        $signals = ForexSignals::where('status',1)->get();
        return view('admin.forex.new', compact('page_title','signals'));
    }

    public function edit($id)
    {
        $account = ForexAccounts::findOrFail($id);
        $signals = ForexSignals::where('status',1)->get();
        $page_title = 'Forex Account Editor';
        return view('admin.forex.edit', compact('page_title','account','signals'));
    }

    public function store(Request $request)
    {
        $request->validate([
    		'number' => 'required|numeric',
    		'password' => 'required|max:80',
    		'balance' => 'required|numeric',
    		'broker' => 'required',
    		'mt' => 'required|numeric',
    	]);

        $account = new ForexAccounts();
        $account->number = $request->number;
        $account->password = $request->password;
        $account->balance = $request->balance;
        $account->broker = $request->broker;
        $account->mt = $request->mt;
        $account->signal1_id = $request->signal1_id;
        $account->signal2_id = $request->signal2_id;
        $account->signal3_id = $request->signal3_id;
        $account->signal4_id = $request->signal4_id;
        $account->signal5_id = $request->signal5_id;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $account->status = $request->status;
        $account->save();

        $notify[] = ['success', 'Forex Account has been Updated'];
        return redirect()->route('admin.forex.index')->withNotify($notify);
    }
    public function update(Request $request)
    {
        $request->validate([
    		'password' => 'required|max:80',
    		'number' => 'required|numeric',
    		'balance' => 'required|numeric',
    		'broker' => 'required',
    		'mt' => 'required',
    	]);

        $account = ForexAccounts::findOrFail($request->id);
        $account->number = $request->number;
        $account->password = $request->password;
        $account->balance = $request->balance;
        $account->broker = $request->broker;
        $account->mt = $request->mt;
        $account->signal1_id = $request->signal1_id;
        $account->signal2_id = $request->signal2_id;
        $account->signal3_id = $request->signal3_id;
        $account->signal4_id = $request->signal4_id;
        $account->signal5_id = $request->signal5_id;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $account->status = $request->status;
        $account->save();

        $notify[] = ['success', 'Forex Account has been Updated'];
        return redirect()->route('admin.forex.index')->withNotify($notify);
    }
    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $account = ForexAccounts::findOrFail($request->id);
        $account->delete();

        $notify[] = ['success', 'Forex Account has been removed'];
        return back()->withNotify($notify);
    }

    public function verify($id)
    {
        $log = ForexLogs::findOrFail($id);
        $account = ForexAccounts::where('user_id',$log->user_id)->first();
        $wallet = Wallet::where('user_id',$log->user_id)->where('symbol','USDT')->first();
        if($log->type == 1){
            $account->balance += $log->amount;
        } else if($log->type == 2) {
            $wallet->balance += $log->amount;
        }
        $wallet->save();
        $account->save();
        $log->status = '1';
        $log->save();

        $notify[] = ['success', 'Transaction has been approved successfully'];
        return back()->withNotify($notify);
    }

    public function log()
    {
    	$page_title = "All Forex Logs List";
    	$empty_message = "No Data Found";
        $user = User::get();
    	$forex_logs = ForexLogs::where('type','!=',3)->latest()->paginate(getPaginate());
    	return view('admin.forex.log', compact('page_title', 'empty_message', 'forex_logs','user'));
    }

    public function pending()
    {
        $page_title = "Pending Forex Logs List";
        $empty_message = "No Data Found";
        $user = User::get();
        $forex_logs = ForexLogs::where('type','!=',3)->where('status', 0)->latest()->paginate(getPaginate());
        return view('admin.forex.log', compact('page_title', 'empty_message', 'forex_logs','user'));
    }

    public function completed()
    {
        $page_title = "Completed Forex Logs List";
        $empty_message = "No Data Found";
        $user = User::get();
        $forex_logs = ForexLogs::where('type','!=',3)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.forex.log', compact('page_title', 'empty_message', 'forex_logs','user'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $user = User::get();
        $empty_message = 'No search result was found.';
        $forex_logs =  ForexLogs::where('type','!=',3)->whereHas('user',function($q) use ($search){
            $q->where('username', $search);
        });
        if($scope == 'pending') {
            $page_title .= 'Pending Forex Logs Search';
            $forex_logs = $forex_logs->where('status', 0);
        }
        elseif($scope == 'completed') {
            $page_title .= 'Completed Forex Logs Search';
            $forex_logs = $forex_logs->where('status', 1);
        }
        elseif($scope == 'list') {
            $page_title .= 'All Forex Logs Search';
        }
        $forex_logs = $forex_logs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.forex.log', compact('page_title', 'empty_message', 'forex_logs', 'search','user'));
    }
}
