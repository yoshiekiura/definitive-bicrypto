<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeLogs;
use App\Models\ThirdpartyOrders;
use App\Models\ThirdpartyProvider;
use App\Models\User;
use Illuminate\Http\Request;

class ManageExchangesController extends Controller
{
    public function __construct()
    {
        if(ThirdpartyProvider::where('status',1)->exists()){
            $thirdparty = ThirdpartyProvider::where('status',1)->first();
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
    public function log()
    {
    	$page_title = "All Trades List";
    	$empty_message = "No Data Found";
        $user = User::get();
        if($this->provider != null){
            $tradeLogs = ThirdpartyOrders::latest()->paginate(getPaginate());
            return view('admin.exchange.provider', compact('page_title', 'empty_message', 'tradeLogs','user'));
        } else {
            $tradeLogs = ExchangeLogs::latest()->paginate(getPaginate());
            return view('admin.exchange.log', compact('page_title', 'empty_message', 'tradeLogs','user'));
        }
    }

    public function pending()
    {
        $page_title = "Pending Trades List";
        $empty_message = "No Data Found";
        $user = User::get();
        if($this->provider != null){
            $tradeLogs = ThirdpartyOrders::where('status', 'open')->orWhere('status','filling')->latest()->paginate(getPaginate());
            return view('admin.exchange.provider', compact('page_title', 'empty_message', 'tradeLogs','user'));
        } else {
            $tradeLogs = ExchangeLogs::where('status', 0)->latest()->paginate(getPaginate());
            return view('admin.exchange.log', compact('page_title', 'empty_message', 'tradeLogs','user'));
        }
    }

    public function completed()
    {
        $page_title = "Completed Trades List";
        $empty_message = "No Data Found";
        $user = User::get();
        if($this->provider != null){
            $tradeLogs = ThirdpartyOrders::where('status', 'closed')->latest()->paginate(getPaginate());
            return view('admin.exchange.provider', compact('page_title', 'empty_message', 'tradeLogs','user'));
        } else {
            $tradeLogs = ExchangeLogs::where('status', 1)->latest()->paginate(getPaginate());
            return view('admin.exchange.log', compact('page_title', 'empty_message', 'tradeLogs','user'));
        }
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $user = User::get();
        $empty_message = 'No search result was found.';
        $tradeLogs =  ExchangeLogs::whereHas('user',function($q) use ($search){
            $q->where('username', $search);
        });
        if($scope == 'pending') {
            $page_title .= 'Pending Exchanges Search';
            $tradeLogs = $tradeLogs->where('status', 0);
        }
        elseif($scope == 'completed') {
            $page_title .= 'Completed Exchanges Search';
            $tradeLogs = $tradeLogs->where('status', 1);
        }
        elseif($scope == 'list') {
            $page_title .= 'All Exchanges Search';
        }
        $tradeLogs = $tradeLogs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.exchange.log', compact('page_title', 'empty_message', 'tradeLogs', 'search','user'));
    }
}
