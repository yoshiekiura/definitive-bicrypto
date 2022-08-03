<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Notifications\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Withdrawals';
        $withdrawals = Withdrawal::where('status', 2)->with(['user','method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        $type = 'pending';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type'));
    }
    public function approved()
    {
        $page_title = 'Approved Withdrawals';
        $withdrawals = Withdrawal::where('status', 1)->with(['user','method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        $type = 'approved';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::where('status', 3)->with(['user','method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        $type = 'rejected';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','type'));
    }

    public function log()
    {
        $page_title = 'Withdrawals Log';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }


    public function logViaMethod($method_id,$type = null){
        $method = WithdrawMethod::findOrFail($method_id);
        if ($type == 'approved') {
            $page_title = 'Approved Withdrawal';
            $withdrawals = Withdrawal::where('status', 1)->with(['user','method'])->latest()->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $page_title = 'Rejected Withdrawals';
            $withdrawals = Withdrawal::where('status', 3)->with(['user','method'])->latest()->paginate(getPaginate());

        }elseif($type == 'pending'){
            $page_title = 'Pending Withdrawals';
            $withdrawals = Withdrawal::where('status', 2)->with(['user','method'])->latest()->paginate(getPaginate());
        }else{
            $page_title = 'Withdrawals';
            $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message','method'));
    }


    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdrawal::with(['user', 'method'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
                });
        });

        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 3);
                break;
            case 'log':
                $page_title .= 'Withdrawal History Search';
                break;
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'search', 'scope', 'withdrawals'));
    }

    public function dateSearch(Request $request,$scope){
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];

        //date validation
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start))  {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.withdraw.log')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.withdraw.log')->withNotify($notify);
        }
        if ($start) {
            $withdrawals = Withdrawal::where('status','!=',0)->whereDate('created_at',Carbon::parse($start));
        }
        if($end){
            $withdrawals = Withdrawal::where('status','!=',0)->whereDate('created_at','>=',Carbon::parse($start))->whereDate('created_at','<=',Carbon::parse($end));
        }
        if ($request->method) {
            $method = WithdrawMethod::findOrFail($request->method);
            $withdrawals = $withdrawals->where('method_id',$method->id);
        }
        if ($scope == 'pending') {
            $withdrawals = $withdrawals->where('status', 2);
        }elseif($scope == 'approved'){
            $withdrawals = $withdrawals->where('status', 1);
        }elseif($scope == 'rejected') {
            $withdrawals = $withdrawals->where('status', 3);
        }
        $withdrawals = $withdrawals->with(['user', 'method'])->paginate(getPaginate());
        $page_title = 'Withdraw Log';
        $empty_message = 'No Withdrawals Found';
        $dateSearch = $search;
        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'dateSearch', 'withdrawals','scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id',$id)->where('status', '!=', 0)->with(['user','method'])->firstOrFail();
        $page_title = $withdrawal->user->username.' Withdraw Requested ' . getAmount($withdrawal->amount) . ' '.$general->cur_text;
        $details = ($withdrawal->withdraw_information != null) ? json_encode($withdrawal->withdraw_information) : null;



        $methodImage =  getImage(imagePath()['withdraw']['method']['path'].'/'. $withdrawal->method->image,'800x800');

        return view('admin.withdraw.detail', compact('page_title', 'withdrawal','details','methodImage'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();
        if($withdraw->save()){
            $wal_trx = WalletsTransactions::where('user_id',$withdraw->user_id)->where('trx', $withdraw->trx)->firstOrFail();
            $wal_trx->status = 1;
            $wal_trx->save();
        }
        try {
            $withdraw->user->notify(new Withdraw($withdraw, $withdraw, 'admin-approved'));
            $notify[] = ['success', 'Client Notified By Email Successfully'];
        } catch (Throwable $e) {
            $notify[] = ['warning', 'Mail Not Properly Set'];
        }
        $notify[] = ['success', 'Client Notified By Email Successfully'];
        $notify[] = ['success', 'Withdrawal Marked as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->firstOrFail();


        $wallet = Wallet::where('user_id',$withdraw->user_id)->where('provider','funding')->where('symbol',$withdraw->symbol)->first();
        $wallet->balance += getAmount($withdraw->amount);

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;

        $wal_trx = WalletsTransactions::where('user_id',$withdraw->user_id)->where('trx', $withdraw->trx)->firstOrFail();
        $wal_trx->status = 3;

        $withdraw->save();
        $wallet->save();
        $wal_trx->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = getAmount($wallet->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from Withdrawal Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();
        try {
            $transaction->user->notify(new Withdraw($transaction, $withdraw, 'admin-rejected'));
            $notify[] = ['success', 'Client Notified By Email Successfully'];
        } catch (Throwable $e) {
            $notify[] = ['warning', 'Mail Not Properly Set'];
        }

        $notify[] = ['success', 'Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

}
