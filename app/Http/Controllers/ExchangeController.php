<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeLogs;
use App\Models\GeneralSetting;
use App\Models\Pairs;
use App\Models\ThirdpartyOrders;
use App\Models\ThirdpartyProvider;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ExchangeController extends Controller
{
    public $provider = null;
    public $pairs = null;
    public function __construct()
    {

        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            if ($thirdparty->title == 'binance') {
                $this->api = new $exchange_class(array(
                    'apiKey' => $thirdparty->api,
                    'secret' => $thirdparty->secret,
                    'password' => $thirdparty->password,
                    'options' => array(
                        'adjustForTimeDifference' => true,
                        'recvWindow' => 30000,
                    ),
                ));
            } else {
                $this->api = new $exchange_class(array(
                    'apiKey' => $thirdparty->api,
                    'secret' => $thirdparty->secret,
                    'password' => $thirdparty->password,
                ));
            }
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

    public function trading($symbol, $currency)
    {
        $gnl = GeneralSetting::first();
        $limits = json_decode(GeneralSetting::where('id', '1')->first()->limits);
        $jsonString = file_get_contents(public_path('data/markets/markets.json'));
        $datas = json_decode($jsonString, true);
        if ($this->provider != null) {
            $pairs = Pairs::where('provider', $this->provider)->where('status', 1)->pluck('symbol');
            $limit = arrayToObject($datas[$this->provider][$currency][$symbol . '/' . $currency]);
            $api = 1;
        } else {
            $pairs = Pairs::where('provider', 'kucoin')->where('status', 1)->pluck('symbol');
            $limit = arrayToObject($datas['kucoin'][$currency][$symbol . '/' . $currency]);
            $api = 0;
        }
        $fee = $gnl->exchange_fee;
        $pfee = 1 + ($fee / 100);
        if ($this->provider == 'coinbasepro') {
            $provide = 'COINBASE';
            $provider = 'coinbasepro';
        } else if ($this->provider != 'coinbasepro' && $this->provider != null) {
            $provide = strtoupper($this->provider);
            $provider = $this->provider;
        } else {
            $provide = 'KUCOIN';
            $provider = 'kucoin';
        }
        return response()->json([
            'provider' => $provider,
            'provide' => $provide,
            'pairs' => $pairs,
            'limits' => $limits,
            'limit' => $limit,
            'fee' => $fee,
            'pfee' => $pfee,
            'api' => $api,
        ]);
    }

    public function trading_orders()
    {
        $user = Auth::user();
        if ($this->provider != null) {
            if (Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'trading')->where('address', '!=', null)->sum('balance') >= 0) {
                $wallets = Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'trading')->where('address', '!=', null)->get();
            } else {
                $wallets = Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'trading')->where('address', '!=', null)->get();
            }
            $orders['market'] = ThirdpartyOrders::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'market')->latest()->get();
            $orders['limit'] = ThirdpartyOrders::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'limit')->latest()->get();
        } else {
            $wallets = Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', 'funding')->where('address', '!=', null)->get();
            $orders['market'] = ExchangeLogs::where('provider', 'local')->where('user_id', $user->id)->where('type', 'market')->latest()->get();
            $orders['limit'] = ExchangeLogs::where('provider', 'local')->where('user_id', $user->id)->where('type', 'limit')->latest()->get();
        }
        return response()->json([
            'wallets' => $wallets,
            'orders' => $orders
        ]);
    }

    public function trading_market_orders($symbol, $currency)
    {
        $user = Auth::user();
        if ($this->provider != null) {
            $orders['closed'] = ThirdpartyOrders::where('user_id', $user->id)->where('provider', $this->provider)->where('symbol', $symbol . '/' . $currency)->where('status', 'closed')->orWhere('status', 'canceled')->latest()->get();
            $orders['open'] = ThirdpartyOrders::where('user_id', $user->id)->where('provider', $this->provider)->where('symbol', $symbol . '/' . $currency)->where('status', 'open')->orWhere('status', 'filling')->latest()->get();
        } else {
            $orders['closed'] = ExchangeLogs::where('user_id', $user->id)->where('provider', 'local')->where('symbol', $symbol . '/' . $currency)->where('status', 'closed')->orWhere('status', 'canceled')->latest()->get();
            $orders['open'] = ExchangeLogs::where('user_id', $user->id)->where('provider', 'local')->where('symbol', $symbol . '/' . $currency)->where('status', 'open')->orWhere('status', 'filling')->latest()->get();
        }
        return response()->json([
            'orders' => $orders
        ]);
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
        if ($request->type == 1) {
            $side = 'buy';
        } else {
            $side = 'sell';
        }
        if ($request->wallettype == 'funding') {
            $provider = 'funding';
        } else {
            $provider = $this->provider;
        }
        if (isWallet($user->id, $request->wallettype, $request->currency, $provider) == true) {
            if (isWallet($user->id, $request->wallettype, $request->symbol, $provider) == true) {
                if ($side == 'buy') {
                    $ws = getWallet($user->id, $request->wallettype, $request->symbol, $provider);
                    $wc = getWallet($user->id, $request->wallettype, $request->currency, $provider);
                    if ($wc->balance > ($feed * $price)) {
                        $pass = '1';
                    } else {
                        $pass = '0';
                    }
                } else {
                    $wc = getWallet($user->id, $request->wallettype, $request->symbol, $provider);
                    $ws = getWallet($user->id, $request->wallettype, $request->currency, $provider);
                    if ($wc->balance > $feed) {
                        $pass = '1';
                    } else {
                        $pass = '0';
                    }
                }
                if ($pass == 0) {
                    if ($this->provider != null) {
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'warning',
                                'message' => 'Your ' . $wc->symbol . ' Balance Not Enough! Please Add Deposit Firstly'
                            ]
                        );
                    } else {
                        $notify[] = ['warning', 'Your ' . $wc->symbol . ' Balance Not Enough! Please Add Deposit Firstly'];
                        return back()->withNotify($notify);
                    }
                } else {
                    if ($this->provider != null && getPlatform('trading')->practice != 1) {
                        $exchangeLog = new ThirdpartyOrders();
                        $exchangeLog->user_id = $user->id;
                        try {
                            if ($request->tradeType != 'limit') {
                                $create_order = $this->api->create_order($request->symbol . '/' . $request->currency, $request->tradeType, $side, $request->amount);
                            } else {
                                $create_order = $this->api->create_order($request->symbol . '/' . $request->currency, $request->tradeType, $side, $request->amount, $request->price);
                            }
                        } catch (Throwable $e) {
                            if ($this->provider == 'binance') {
                                return response()->json(
                                    [
                                        'success' => true,
                                        'type' => 'warning',
                                        'message' => json_decode(str_replace($this->provider . ' ', '', $e->getMessage()))->msg,
                                    ]
                                );
                            } else {
                                return response()->json(
                                    [
                                        'success' => true,
                                        'type' => 'error',
                                        'message' => str_replace($this->provider . ' ', '', $e->getMessage()),
                                    ]
                                );
                            }
                        }
                        $fetch_order = $this->api->fetch_order($create_order['id'], $request->symbol . '/' . $request->currency);
                        $exchangeLog->order_id = $create_order['id'];
                        $exchangeLog->symbol = $create_order['symbol'];
                        $exchangeLog->type = $create_order['type'];
                        $exchangeLog->side = $create_order['side'];
                        $exchangeLog->price =  $fetch_order['price'];
                        $exchangeLog->stopPrice =  $fetch_order['stopPrice'];
                        $exchangeLog->amount = $request->amount;
                        $exchangeLog->cost = $fetch_order['cost'];
                        $exchangeLog->average = $fetch_order['average'];
                        $exchangeLog->filled = $fetch_order['filled'];
                        $exchangeLog->remaining = $fetch_order['remaining'];
                        $exchangeLog->status = $fetch_order['status'];
                        if ($this->provider == 'binance') {
                            $exchangeLog->fee = $fetch_order['fee'];
                        } else {
                            $exchangeLog->fee = $fetch_order['fee']['cost'];
                        }
                        $exchangeLog->provider = $this->provider;
                        $exchangeLog->save();

                        if ($side == 'buy') {
                            $wc->balance -= $feed * $price;
                            $wc->save();
                            if ($fetch_order['remaining'] == 0) {
                                $ws->balance += $request->amount;
                                $ws->save();
                            }
                        } else {
                            $wc->balance -= $feed;
                            $wc->save();
                            if ($fetch_order['remaining'] == 0) {
                                $ws->balance += $request->amount * $exchangeLog->price;
                                $ws->save();
                            }
                        }
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'success',
                                'message' => ucfirst($exchangeLog->side) . ' Order of (' . $request->amount . ' ' . getPair($exchangeLog->symbol)[0] . ') placed successfully'
                            ]
                        );
                    } else {
                        $exchangeLog = new ExchangeLogs();
                        $exchangeLog->user_id = $user->id;
                        $exchangeLog->order_id = getTrx();
                        $exchangeLog->symbol = $request->symbol . '/' . $request->currency;
                        $exchangeLog->type = $request->tradeType;
                        if ($request->type == 1) {
                            $exchangeLog->side = 'buy';
                        } else if ($request->type == 2) {
                            $exchangeLog->side = 'sell';
                        }
                        $exchangeLog->price =  $request->price;
                        $exchangeLog->amount = $request->amount;
                        $exchangeLog->cost = $request->price * $request->amount;
                        $exchangeLog->average = $request->price;
                        $exchangeLog->filled = $request->amount;
                        $exchangeLog->remaining = 0;
                        $exchangeLog->status = $request->status;
                        $exchangeLog->fee = $fee;
                        $exchangeLog->provider = 'local';
                        if ($exchangeLog->type == 'market') {
                            $exchangeLog->status = 'closed';
                        } else if ($exchangeLog->type == 'limit') {
                            $exchangeLog->status = 'open';
                        }
                        $exchangeLog->save();

                        if ($side == 'buy') {
                            $wc->balance -= $feed * $price;
                            $wc->save();
                            $ws->balance += $request->amount;
                            $ws->save();
                        } else {
                            $wc->balance -= $feed;
                            $wc->save();
                            $ws->balance += $exchangeLog->cost;
                            $ws->save();
                        }
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'success',
                                'message' => ucfirst($exchangeLog->side) . ' Order of (' . $request->amount . ' ' . getPair($exchangeLog->symbol)[0] . ') placed successfully'
                            ]
                        );
                    }
                }
            } else {
                return response()->json(
                    [
                        'success' => true,
                        'type' => 'warning',
                        'message' => 'Create Wallets Firstly'
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'warning',
                    'message' => 'Create Wallets Firstly'
                ]
            );
        }
    }

    public function cancel(Request $request)
    {
        $log = ThirdpartyOrders::where('provider', $this->provider)->where('order_id', $request->order_id)->first();
        if ($this->provider != null) {
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
        $from = getWallet($log->user_id, 'trading', getPair($request->symbol)['0'], $this->provider);
        $to = getWallet($log->user_id, 'trading', getPair($request->symbol)['1'], $this->provider);
        if ($log->type = 'buy') {
            $from->balance -= $log->feed;
            $to->balance += $log->amount;
        } elseif ($log->type = 'sell') {
            $from->balance += $log->amount + $fee;
            $to->balance -= $log->feed;
        }
        $from->save();
        $to->save();
        return 1;
    }
}
