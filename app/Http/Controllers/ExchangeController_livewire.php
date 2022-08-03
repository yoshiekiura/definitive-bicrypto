<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeLogs;
use App\Models\GeneralSetting;
use App\Models\Markets;
use App\Models\Pairs;
use App\Models\Platform;
use App\Models\ThirdpartyOrders;
use App\Models\ThirdpartyProvider;
use App\Models\Wallet;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\File;

class ExchangeController extends Controller
{
    public $provider = null;
    public $pairs = null;
    public function __construct()
    {

        if(ThirdpartyProvider::where('status',1)->exists()){
            $thirdparty = ThirdpartyProvider::where('status',1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            $exchange_pro_class = "\\ccxtpro\\$thirdparty->title";
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

	public function btcRate(Request $request)
    {
	    $cryptoRate = getCoinRate($request->coinSymbol);
	    return $cryptoRate;
    }

    public function home(Request $request)
    {
        $page_title = 'Exchange Dashboard';
        $user = Auth::user();
		$empty_message = "No Orders Found";
        if($this->provider != null){
            if(Wallet::where('provider',$this->provider)->where('user_id', $user->id)->where('type','trading')->where('address','!=',null)->sum('balance') >= 0){
                $wallets = Wallet::where('provider',$this->provider)->where('user_id', $user->id)->where('type','trading')->where('address','!=',null)->get();
            } else {
                $wallets = Wallet::where('provider',$this->provider)->where('user_id', $user->id)->where('type','trading')->where('address','!=',null)->get();
            }
            $orders['market'] = ThirdpartyOrders::where('provider',$this->provider)->where('user_id',$user->id)->where('type','market')->latest()->paginate(getPaginate(10));
            $orders['limit'] = ThirdpartyOrders::where('provider',$this->provider)->where('user_id',$user->id)->where('type','limit')->latest()->paginate(getPaginate(10));
            return view('user.dashboard.exchange', compact('page_title', 'user','wallets','orders','empty_message'));
        } else {
            $exchanges = ExchangeLogs::where('user_id', $user->id)->get();
            if(Wallet::where('user_id', $user->id)->where('type','funding')->sum('balance') >= 0){
                $wallets = Wallet::where('user_id', $user->id)->where('type','funding')->get();
            }
            $exchanges = ExchangeLogs::where('user_id', $user->id)->get();
            $gnl = GeneralSetting::first();
            $platform = Platform::where('id',1)->first();
            return view('user.dashboard.exchange_noparty', compact('page_title', 'user', 'exchanges','wallets','platform','gnl'));
        }
    }

	public function index()
	{
		$page_title = "Exchange Now";
		$empty_message = "No Data Found";
        $user = Auth::user();
        if ($this->provider != null){
            $markets = Markets::where('provider',$this->provider)->where('status',1)->get();
        } else {
            $markets = null;
        }
		return view('user.contract.index', compact('page_title', 'empty_message','markets'));
	}

    public function exchange($symbol, $currency)
    {
    	$page_title = $symbol.'/'.$currency." Trade";
        $user = Auth::user();
    	$gnl = GeneralSetting::first();
        $contracts = ExchangeLogs::where('user_id', $user->id)->where('from', $symbol)->latest()->limit(10)->get();
        $limits = json_decode(GeneralSetting::where('id','1')->first()->limits);
        if($this->provider != null){
            if ($this->provider == 'coinbasepro'){
                $provider = 'COINBASE';
                $provide = 'coinbasepro';
            } else if ($this->provider == 'kucoin'){
                $provider = 'KUCOIN';
                $provide = 'kucoin';
            }
            $exchange = $this->provider;

            $pairs = Pairs::where('provider',$this->provider)->where('status',1)->pluck('symbol');
            $jsonString = file_get_contents(public_path('data/markets/markets.json'));
            $datas = json_decode($jsonString, true);
            foreach($pairs as $pair) {
                foreach($datas[$this->provider] as $data) {
                    if($data['pair'] == $pair){
                        $markets[$pair][] = $data;
                    }
                }
            }
            $limit = arrayToObject($datas[$this->provider][$symbol.'/'.$currency]);

            if(isWallet($user->id,'trading',$symbol,$this->provider) == true){
                $wallet['symbol'] = getWallet($user->id,'trading',$symbol,$this->provider);
            } else {
                $wallet['symbol'] = null;
            }
            if(isWallet($user->id,'trading',$currency,$this->provider) == true){
                $wallet['currency'] = getWallet($user->id,'trading',$currency,$this->provider);
            } else {
                $wallet['currency'] = null;
            }
            $cors = File::get(resource_path('assets/cors.txt'));
            $fee = $gnl->exchange_fee;
            $pfee = 1 + ($fee / 100);
    	    return view('user.contract.exchange', compact('page_title','exchange','gnl','pfee','fee','wallet','cors','limits','contracts','limit','symbol','currency','provider','provide','markets','pairs'));
        } else {
            if(isWallet($user->id,'funding',$symbol,'funding') == true){
                $fromW = getWallet($user->id,'funding',$symbol,'funding');
                $from_balance = getAmount($fromW->balance);
            } else {
                $fromW = '0';
                $from_balance = 'Wallet Dont Exist';
            }
            if(isWallet($user->id,'funding',$currency,'funding') == true){
                $toW = getWallet($user->id,'funding',$currency,'funding');
                $to_balance = getAmount($toW->balance);
            } else {
                $toW = '0';
                $to_balance = 'Wallet Dont Exist';
            }
            return view('user.contract.exchange_noparty', compact('page_title','gnl','symbol','limits','contracts','currency','from_balance','to_balance','fromW','toW'));
        }
    }

    public function store(Request $request)
    {
        //dd($request);
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'price' => 'numeric',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $user = Auth::user();
        $fee = (GeneralSetting::first()->exchange_fee / 100) * $request->amount;
        $feed = $request->amount + $fee;
        $price = $request->price;
        if($request->type == 1){
            $side = 'buy';
        } else {
            $side = 'sell';
        }
        if($request->wallettype == 'funding'){
            $provider = 'funding';
        } else {
            $provider = $this->provider;
        }
        if(isWallet($user->id,$request->wallettype,$request->currency,$provider) == true){
            if(isWallet($user->id,$request->wallettype,$request->symbol,$provider) == true){
                if($side == 'buy'){
                    $ws = getWallet($user->id,$request->wallettype,$request->symbol,$provider);
                    $wc = getWallet($user->id,$request->wallettype,$request->currency,$provider);
                    if($wc->balance > ($feed * $price) ){
                        $pass = '1';
                    } else {
                        $pass = '0';
                    }
                } else {
                    $wc = getWallet($user->id,$request->wallettype,$request->symbol,$provider);
                    $ws = getWallet($user->id,$request->wallettype,$request->currency,$provider);
                    if($wc->balance > $feed){
                        $pass = '1';
                    } else {
                        $pass = '0';
                    }
                }
                if($pass == 0){
                    if($this->provider != null){
                        $response = [
                            'value'         => 2,
                            'message' => 'Your ' . $wc->symbol .' Balance Not Enough! Please Add Deposit Firstly',
                        ];
                        return response()->json($response);
                    } else {
                        $notify[] = ['warning', 'Your ' . $wc->symbol .' Balance Not Enough! Please Add Deposit Firstly'];
                        return back()->withNotify($notify);
                    }
                } else {
                    if($this->provider != null){
                        try {
                            $exchangeLog = new ThirdpartyOrders();
                            $exchangeLog->user_id = $user->id;
                            $placeOrder = $this->api->create_order($request->symbol.'/'.$request->currency, $request->tradeType, $side, $request->amount, $request->price);
                            if($this->provider == 'kucoin'){
                                $fetchOrder = $this->api->fetch_order($placeOrder['info']['orderId'],$request->symbol.'/'.$request->currency);
                                $exchangeLog->order_id = $placeOrder['info']['orderId'];
                            } else if($this->provider == 'coinbasepro'){
                                $fetchOrder = $this->api->fetch_order($placeOrder['info']['id'],$request->symbol.'/'.$request->currency);
                                $exchangeLog->order_id = $placeOrder['info']['id'];
                            }
                            $exchangeLog->symbol = $placeOrder['symbol'];
                            $exchangeLog->type = $placeOrder['type'];
                            $exchangeLog->side = $placeOrder['side'];
                            $exchangeLog->price =  $fetchOrder['price'];
                            $exchangeLog->stopPrice =  $fetchOrder['stopPrice'];
                            $exchangeLog->amount = $request->amount;
                            $exchangeLog->cost = $fetchOrder['cost'];
                            $exchangeLog->average = $fetchOrder['average'];
                            $exchangeLog->filled = $fetchOrder['filled'];
                            $exchangeLog->remaining = $fetchOrder['remaining'];
                            $exchangeLog->status = $fetchOrder['status'];
                            $exchangeLog->fee = $fetchOrder['fee']['cost'];
                            $exchangeLog->provider = $this->provider;
                            $exchangeLog->save();

                            if($request->tradeType == 'market'){
                                if($side == 'buy'){
                                    $ws->balance += $request->amount;
                                    $ws->save();

                                    $wc->balance -= $feed * $price;
                                    $wc->save();
                                } else {
                                    $ws->balance += $request->amount * $exchangeLog->price;
                                    $ws->save();

                                    $wc->balance -= $feed;
                                    $wc->save();
                                }
                            } else {
                                if($side == 'buy'){
                                    $wc->balance -= $feed * $price;
                                    $wc->save();
                                } else {
                                    $wc->balance -= $feed;
                                    $wc->save();
                                }
                            }

                            return 1;
                        } catch (Throwable $e) {
                            $response = [
                                'value'         => 2,
                                'message' => 'Something went wrong, please contact support er0x001',
                            ];
                            return response()->json($response);
                        }
                    } else {
                        $ws->balance += $request->amount ;
                        $ws->save();
                        $wc->balance -= $feed * (getCoinRate($ws->symbol) / getCoinRate($wc->symbol));
                        $wc->save();
                        $exchangeLog = new ExchangeLogs();
                        $exchangeLog->user_id = $user->id;
                        $exchangeLog->from = $wc->symbol;
                        $exchangeLog->to = $ws->symbol;
                        $exchangeLog->amount_from = $request->amount;
                        $exchangeLog->price_was = getCoinRate($ws->symbol);
                        $exchangeLog->status = '1';
                        $exchangeLog->type = '1';
                        $exchangeLog->save();
                        $notify[] = ['success', 'You Bought ' .$request->amount.' '. $ws->symbol .' Successfully'];
                        return back()->withNotify($notify);
                    }
                }
            } else {
                if($this->provider != null){
                    $response = [
                        'value'         => 2,
                        'message' => 'Create Wallets Firstly',
                    ];
                    return response()->json($response);
                } else {
                    $notify[] = ['warning', 'Create Wallets Firstly'];
                    return back()->withNotify($notify);
                }
            }
        } else {
            if($this->provider != null){
                $response = [
                    'value'         => 2,
                    'message' => 'Create Wallets Firstly',
                ];
                return response()->json($response);
            } else {
                $notify[] = ['warning', 'Create Wallets Firstly'];
                return back()->withNotify($notify);
            }
        }
    }

    public function cancel(Request $request)
    {
        $log = ThirdpartyOrders::where('provider',$this->provider)->where('order_id',$request->order_id)->first();
        if($this->provider != null){
            try {
                $this->api->cancel_order($request->order_id, $request->symbol);
            } catch (Throwable $e) {
                $response = [
                    'value'         => 2,
                    'message' => 'Order Cancellation Failed, Please report to support',
                ];
                return response()->json($response);
            }
        } else {
            $response = [
                'value'         => 2,
                'message' => 'Something went wrong, please contact support er0x002',
            ];
            return response()->json($response);
        }
        $log->status = 'canceled';
        $log->save();
        $fee = (GeneralSetting::first()->exchange_fee / 100) * $log->amount;
        $from = getWallet($log->user_id,'trading',getPair($request->symbol)['0'],$this->provider);
        $to = getWallet($log->user_id,'trading',getPair($request->symbol)['1'],$this->provider);
        if($log->type = 'buy'){
            $from->balance -= $log->feed;
            $to->balance += $log->amount;
        } elseif($log->type = 'sell'){
            $from->balance += $log->amount + $fee;
            $to->balance -= $log->feed;
        }
        $from->save();
        $to->save();
        return 1;
    }

    public function exchangeLog()
    {
        $user = Auth::user();
        $exchanges = ExchangeLogs::where('user_id', $user->id)->get();
        $page_title = "Exchange History";
        $empty_message = "No Data Found";
        return view('user.contract.log', compact('page_title', 'empty_message','exchanges'));
    }

}
