<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotContract;
use App\Models\ExchangeLogs;
use App\Models\Extension;
use App\Models\ForexLogs;
use App\Models\IcoLogs;
use App\Models\MLM;
use App\Models\PracticeLog;
use App\Models\StakingLog;
use App\Models\ThirdpartyOrders;
use App\Models\TradeLog;
use App\Models\User;
use App\Models\Wallet;

class DatabaseController extends Controller
{
    public function index()
    {
        $page_title = 'Database Optimizer';
        $bot = Extension::where('id',1)->first();
        $mlm = Extension::where('id',3)->first();
        return view('admin.setting.database', compact('page_title','bot','mlm'));
    }

    public function regenerate()
    {
        $users = User::get();
        foreach($users as $user){
            if(!MLM::where('username',$user->username)->exists()){
                $mlm = new MLM();
                $mlm->username = $user->username;
                $mlm->save();
            }
        }
        $notify[] = ['success', 'All Non Existing Users Rows Regenerated'];
        return back()->withNotify($notify);
    }

    public function clean_binary_practice_logs()
    {
        $logs = PracticeLog::get();
        foreach($logs as $log){
            $log->delete();
        }
        $files = glob(public_path('data/practice/*')); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
        $notify[] = ['success', 'All Binary Practice Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_binary_trade_logs()
    {
        $logs = TradeLog::get();
        foreach($logs as $log){
            $log->delete();
        }
        $files = glob(public_path('data/trade/*')); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
        $notify[] = ['success', 'All Binary Trade Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_trade_logs()
    {
        $logs = ThirdpartyOrders::get();
        foreach($logs as $log){
            $log->delete();
        }
        $Elogs = ExchangeLogs::get();
        foreach($Elogs as $Elog){
            $Elog->delete();
        }
        $notify[] = ['success', 'All Trade Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_forex_investments_logs()
    {
        $logs = ForexLogs::get();
        foreach($logs as $log){
            $log->delete();
        }
        $notify[] = ['success', 'All Forex Investment Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_bot_investments_logs()
    {
        $logs = BotContract::get();
        foreach($logs as $log){
            $log->delete();
        }
        $notify[] = ['success', 'All Bot Investment Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_staking_logs()
    {
        $logs = StakingLog::get();
        foreach($logs as $log){
            $log->delete();
        }
        $notify[] = ['success', 'All Staking Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_ico_logs()
    {
        $logs = IcoLogs::get();
        foreach($logs as $log){
            $log->delete();
        }
        $notify[] = ['success', 'All Token ICO Logs Cleaned'];
        return back()->withNotify($notify);
    }

    public function clean_wallets()
    {
        $wallets = Wallet::where('address',null)->orWhere('address', '')->get();
        foreach($wallets as $wallet){
            $wallet->delete();
        }
        $notify[] = ['success', 'All Broken Wallets Cleaned'];
        return back()->withNotify($notify);
    }
}
