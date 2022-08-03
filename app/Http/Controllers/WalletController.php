<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\BinanceCurrencies;
use App\Models\BybitCurrencies;
use App\Models\CoinbaseCurrencies;
use App\Models\KucoinCurrencies;
use App\Models\ThirdpartyProvider;
use App\Models\ThirdpartyTransactions;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class WalletController extends Controller
{
    public function __construct()
    {
        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            if ($thirdparty->title == 'kucoin') {
                $this->api = new $exchange_class(array(
                    'apiKey' => $thirdparty->api,
                    'secret' => $thirdparty->secret,
                    'password' => $thirdparty->password,
                    'options' => array(
                        'versions' => array(
                            'public' => array(
                                'GET' => array(
                                    'currencies/{currency}' => 'v2',
                                ),
                            ),
                        ),
                    ),
                    //'verbose'=> true
                ));
            } else if ($thirdparty->title == 'binance') {
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
            $this->provider = 'funding';
        }
        #$this->api->set_sandbox_mode('enable');
    }

    function fetch_create_deposit_address_helper($exchange, $code, $chain = null)
    {
        $response = null;
        try {
            $response = $exchange->fetch_deposit_address($code, $chain ? array('chain' => strtolower($chain)) : array());
            if ((!$response['address']) || (!strlen($response['address']))) {
                throw new \ccxt\ExchangeError($exchange->id);
            }
        } catch (\ccxt\ExchangeError $e) {
            $response = $exchange->create_deposit_address($code, $chain ? array('chain' => strtolower($chain)) : array());
        }
        return $response;
    }

    function fetch_create_deposit_address($exchange, $code, $chainName, $chain = null)
    {
        try {
            return $this->fetch_create_deposit_address_helper($exchange, $code, $chain);
        } catch (\ccxt\ExchangeError $e) {
        }
    }

    public function fetch_wallets()
    {
        $user = Auth::user();
        if ($this->provider != 'funding') {
            if (Wallet::where('provider', $this->provider)->where('user_id', $user->id)->exists()) {
                $wallets['trading'] = Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'trading')->get();
                $wallets['funding'] = Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', 'funding')->get();
            } else {
                $wallets['trading'] = null;
                $wallets['funding'] = null;
            }
            if ($this->provider == 'coinbasepro') {
                $currencies = CoinbaseCurrencies::where('status', 1)->get();
            } else if ($this->provider == 'kucoin') {
                $currencies = KucoinCurrencies::where('status', 1)->get();
            } else if ($this->provider == 'binance') {
                $currencies = BinanceCurrencies::where('status', 1)->get();
            } else if ($this->provider == 'bybit') {
                $currencies = BybitCurrencies::where('status', 1)->get();
            } else {
                $currencies = null;
            }
            return response()->json([
                'user' => $user,
                'wallets' => $wallets,
                'api' => 1,
                'currencies' => $currencies,
            ]);
        } else {
            if (Wallet::where('provider', 'funding')->where('user_id', $user->id)->exists()) {
                $wallets['funding'] = Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', 'funding')->get();
            } else {
                $wallets['funding'] = null;
            }
            $currencies = KucoinCurrencies::where('status', 1)->get();
            return response()->json([
                'user' => $user,
                'wallets' => $wallets,
                'api' => 0,
                'currencies' => $currencies,
            ]);
        }
    }


    public function fetch_wallet($type, $symbol, $address)
    {
        $user = Auth::user();
        $wal = Wallet::where('user_id', $user->id)->where('address', $address)->where('symbol', $symbol)->first();
        $wal_trx = WalletsTransactions::where('user_id', $user->id)->where('symbol', $wal->symbol)->orWhere('to', $wal->symbol)->latest()->get();
        session()->put('Track', $wal);
        if ($this->provider != 'funding') {
            if ($this->provider == 'coinbasepro') {
                $currencies = CoinbaseCurrencies::where('status', 1)->get();
                $curr = CoinbaseCurrencies::where('symbol', $wal->symbol)->first();
                $wallets = null;
                $chains = null;
            } else if ($this->provider == 'binance') {
                $currencies = BinanceCurrencies::where('status', 1)->get();
                $curr = BinanceCurrencies::where('symbol', $wal->symbol)->first();
                $wallets = json_decode($wal->addresses);
                $chainss = json_decode($curr->networks, True);
                foreach ($chainss as $chain) {
                    if ($chain['withdrawEnable'] == true) {
                        $chains[] = $chain;
                    }
                }
            } else if ($this->provider == 'bybit') {
                $currencies = BybitCurrencies::where('status', 1)->get();
                $curr = BybitCurrencies::where('symbol', $wal->symbol)->first();
                $wallets = json_decode($wal->addresses);
                $chains = json_decode($curr->networks);
            } else if ($this->provider == 'kucoin') {
                $wallets = json_decode($wal->addresses);
                $response = $this->api->public_get_currencies_currency(array('currency' => $symbol));
                $currency = $this->api->safe_value($response, 'data');
                if ($currency) {
                    $chainss = collect($this->api->safe_value($currency, 'chains'));
                    foreach ($chainss->where('isWithdrawEnabled', true) as $chain) {
                        $chains[] = $chain;
                    }
                }
                $currencies = KucoinCurrencies::where('status', 1)->get();
                $curr = KucoinCurrencies::where('symbol', $wal->symbol)->first();
            } else {
                $currencies = null;
                $curr = null;
            }
            $provider = $this->provider;
            return response()->json([
                'wal' => $wal,
                'wal_trx' => $wal_trx,
                'wallets' => $wallets,
                'currencies' => $currencies,
                'curr' => $curr,
                'provider' => $provider,
                'currency' => getCurrency(),
                'chains' => $chains,
                'api' => 1,
            ]);
        } else {
            $provider = $this->provider;
            return response()->json([
                'wal' => $wal,
                'wal_trx' => $wal_trx,
                'wallets' => null,
                'currencies' => null,
                'curr' => null,
                'provider' => $provider,
                'currency' => getCurrency(),
                'chains' => null,
                'api' => 0,
            ]);
        }
    }

    public function fetch_wallet_balance(Request $request)
    {
        if ($request->type == 'funding') {
            if (isWallet(auth()->user()->id, 'funding', $request->symbol, 'funding') == false) {
                return response()->json([
                    'symbol' => null,
                    'balance' => null
                ]);
            } else {
                $wallet = getWallet(auth()->user()->id, 'funding', $request->symbol, 'funding');
                return response()->json([
                    'symbol' => $wallet->symbol,
                    'balance' => $wallet->balance
                ]);
            }
        } else {
            if (isWallet(auth()->user()->id, 'trading', $request->symbol, $this->provider) == false) {
                return response()->json([
                    'symbol' => null,
                    'balance' => null
                ]);
            } else {
                $wallet = getWallet(auth()->user()->id, 'trading', $request->symbol, $this->provider);
                return response()->json([
                    'symbol' => $wallet->symbol,
                    'balance' => $wallet->balance
                ]);
            }
        }
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        if ($request->symbol == null) {
            $notify[] = ['warning', 'Select wallet type!'];
        } else {
            if (Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
                $notify[] = ['warning', 'You Have ' . $request->symbol . ' Wallet Already!'];
            } else {
                if ($request->type == 'trading') {
                    $wallet = new Wallet();
                    $wallet->user_id = $user->id;
                    $wallet->provider = $this->provider;
                    $wallet->symbol = $request->symbol;
                    $wallet->type = 'trading';
                    if ($this->provider == 'coinbasepro') {
                        try {
                            $wallet->address = $this->api->create_deposit_address($request->symbol)['address'];
                            $wallet->save();
                            $notify[] = ['success', 'Your ' . $wallet->symbol . ' Wallet Created Successfully'];
                        } catch (Throwable $e) {
                            $notify[] = ['warning', 'Wallet Generation Failed, Please report to support'];
                        }
                    } else if ($this->provider == 'binance') {
                        try {
                            $wallet->address = $this->api->create_deposit_address($request->symbol)['address'];
                            $wallet->save();
                            $notify[] = ['success', 'Your ' . $wallet->symbol . ' Wallet Created Successfully'];
                        } catch (Throwable $e) {
                            $notify[] = ['warning', 'Wallet Generation Failed, Please report to support'];
                        }
                    } else if ($this->provider == 'kucoin') {
                        $response = $this->api->public_get_currencies_currency(array('currency' => $request->symbol));
                        $currency = $this->api->safe_value($response, 'data');
                        $results = array();
                        if ($currency) {
                            $chains = $this->api->safe_value($currency, 'chains');
                            if ((count($chains) > 1) && ($request->symbol !== 'BNB')) {
                                foreach ($chains as $chain) {
                                    $chainName = $this->api->safe_string($chain, 'chainName');
                                    $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName, $chainName);
                                    if (!isset($results)) {
                                        $results = array();
                                    }
                                    $results[$chainName] = $address;
                                }
                            } else {
                                $chain = $this->api->safe_value($chains, 0);
                                $chainName = $this->api->safe_string($chain, 'chainName');
                                $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName);
                                if (!isset($results)) {
                                    $results = array();
                                }
                                $results[$chainName] = $address;
                            }
                            $results = array_filter($results);
                            $wallet->addresses = json_encode($results);
                            if (reset($results) != null) {
                                $wallet->address = reset($results)['address'];
                                $notify[] = ['success', 'Your ' . $wallet->symbol . ' Wallet Created Successfully'];
                                $wallet->save();
                            } else {
                                $notify[] = ['warning', 'Wallet Generation Failed, No Address Created'];
                            }
                        } else {
                            $notify[] = ['warning', 'Wallet Generation Failed, Please report to support'];
                        }
                    }
                } else {
                    if (Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
                        $notify[] = ['warning', 'You Have ' . $request->symbol . ' Wallet Already!'];
                    } else {
                        $wallet = new Wallet();
                        $wallet->user_id = $user->id;
                        $wallet->symbol = $request->symbol;
                        $wallet->address = grs(34);
                        $wallet->type = 'funding';
                        $wallet->provider = 'funding';
                        $notify[] = ['success', 'Your ' . $wallet->symbol . ' Wallet Created Successfully'];
                        $wallet->save();
                    }
                }
            }
        }
        return back()->withNotify($notify);
    }

    public function create_json(Request $request)
    {
        $user = Auth::user();
        if (Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'warning',
                    'message' => 'You Have ' . $request->symbol . ' Wallet Already!'
                ]
            );
        } else {
            if ($request->type == 'trading') {
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->provider = $this->provider;
                $wallet->symbol = $request->symbol;
                $wallet->type = $request->type;
                if ($this->provider == 'coinbasepro') {
                    try {
                        $wallet->address = $this->api->create_deposit_address($request->symbol)['address'];
                        $wallet->save();
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'success',
                                'message' => 'Your ' . $wallet->symbol . ' Wallet Created Successfully'
                            ]
                        );
                    } catch (Throwable $e) {
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'warning',
                                'message' => 'Wallet Generation Failed, Please report to support'
                            ]
                        );
                    }
                } else if ($this->provider == 'binance') {
                    $curr = BinanceCurrencies::where('symbol', $request->symbol)->first();
                    $chainss = json_decode($curr->networks, True);
                    foreach ($chainss as $chain) {
                        if ($chain['withdrawEnable'] == true) {
                            $chains[] = $chain;
                        }
                    }
                    $results = array();
                    if (count($chains) > 1) {
                        foreach ($chains as $chain) {
                            $chainName = $this->api->safe_string($chain, 'network');
                            try {
                                $address = $this->api->fetch_deposit_address($request->symbol, ["network" => $chainName]);
                            } catch (Throwable $e) {
                                return response()->json(
                                    [
                                        'success' => true,
                                        'type' => 'warning',
                                        'message' => str_replace($this->provider . ' ', '', $e->getMessage()),
                                    ]
                                );
                            }
                            if (!isset($results)) {
                                $results = array();
                            }
                            $results[$chainName] = $address;
                        }
                    } else {
                        $chain = $this->api->safe_value($chains, 0);
                        $chainName = $this->api->safe_string($chain, 'network');
                        try {
                            $address = $this->api->fetch_deposit_address($request->symbol, ["network" => $chainName]);
                        } catch (Throwable $e) {
                            return response()->json(
                                [
                                    'success' => true,
                                    'type' => 'warning',
                                    'message' => str_replace($this->provider . ' ', '', $e->getMessage()),
                                ]
                            );
                        }
                        if (!isset($results)) {
                            $results = array();
                        }
                        $results[$chainName] = $address;
                    }
                    $results = array_filter($results);
                    $wallet->addresses = json_encode($results);
                    try {
                        $wallet->address = reset($results)['address'];
                        $wallet->save();
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'success',
                                'message' => 'Your ' . $wallet->symbol . ' Wallet Created Successfully'
                            ]
                        );
                    } catch (Throwable $e) {
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'warning',
                                'message' => json_decode(str_replace($this->provider . ' ', '', $e->getMessage()))->msg,
                            ]
                        );
                    }
                } else if ($this->provider == 'bybit') {
                    try {
                        $wallet->address = $this->api->fetch_deposit_address($request->symbol)['address'];
                        $wallet->addresses = json_encode($this->api->fetch_deposit_addresses_by_network($request->symbol));
                        $wallet->save();
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'success',
                                'message' => 'Your ' . $wallet->symbol . ' Wallet Created Successfully'
                            ]
                        );
                    } catch (Throwable $e) {
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'warning',
                                'message' => str_replace($this->provider . ' ', '', $e->getMessage()),
                            ]
                        );
                    }
                } else if ($this->provider == 'kucoin') {
                    $response = $this->api->public_get_currencies_currency(array('currency' => $request->symbol));
                    $currency = $this->api->safe_value($response, 'data');
                    $results = array();
                    if ($currency) {
                        $chains = $this->api->safe_value($currency, 'chains');
                        if ((count($chains) > 1) && ($request->symbol !== 'BNB')) {
                            foreach ($chains as $chain) {
                                $chainName = $this->api->safe_string($chain, 'chainName');
                                $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName, $chainName);
                                if (!isset($results)) {
                                    $results = array();
                                }
                                $results[$chainName] = $address;
                            }
                        } else {
                            $chain = $this->api->safe_value($chains, 0);
                            $chainName = $this->api->safe_string($chain, 'chainName');
                            $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName);
                            if (!isset($results)) {
                                $results = array();
                            }
                            $results[$chainName] = $address;
                        }
                        $results = array_filter($results);
                        $wallet->addresses = json_encode($results);
                        try {
                            $wallet->address = reset($results)['address'];
                            $wallet->save();
                            return response()->json(
                                [
                                    'success' => true,
                                    'type' => 'success',
                                    'message' => 'Your ' . $wallet->symbol . ' Wallet Created Successfully'
                                ]
                            );
                        } catch (Throwable $e) {
                            return $e;
                        }
                    } else {
                        return response()->json(
                            [
                                'success' => true,
                                'type' => 'warning',
                                'message' => 'Wallet Generation Failed, Please report to support'
                            ]
                        );
                    }
                }
            } else {
                if (Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
                    return response()->json(
                        [
                            'success' => true,
                            'type' => 'warning',
                            'message' => 'You Have ' . $request->symbol . ' Wallet Already!'
                        ]
                    );
                } else {
                    $wallet = new Wallet();
                    $wallet->user_id = $user->id;
                    $wallet->symbol = $request->symbol;
                    $wallet->address = grs(34);
                    $wallet->type = 'funding';
                    $wallet->provider = 'funding';
                    $wallet->save();
                    return response()->json(
                        [
                            'success' => true,
                            'type' => 'success',
                            'message' => 'Your ' . $wallet->symbol . ' Wallet Created Successfully'
                        ]
                    );
                }
            }
        }
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        if (ThirdpartyTransactions::where('address', $request->address)->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Transaction Hash Already Used'
                ]
            );
        } else {

            $deposit = new ThirdpartyTransactions();
            $deposit->user_id = $user->id;
            $deposit->symbol = $request->symbol;
            $deposit->recieving_address = $request->recieving_address;
            $deposit->address = $request->address;
            $deposit->chain = $request->chain;
            $deposit->type = '1';
            $deposit->status = '0';
            $deposit->save();

            $wallet_new_trx = new WalletsTransactions();
            $wallet_new_trx->symbol = $request->symbol;
            $wallet_new_trx->user_id = $user->id;
            $wallet_new_trx->address = $request->address;
            $wallet_new_trx->to = $request->recieving_address;
            $wallet_new_trx->chain = $request->chain;
            $wallet_new_trx->type = '1';
            $wallet_new_trx->status = '2';
            $wallet_new_trx->details = 'Deposited To ' . $request->symbol . ' Wallet ';
            $wallet_new_trx->wallet_type = 'trading';
            $wallet_new_trx->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'New Deposit From ' . $user->username;
            $adminNotification->click_url = route('admin.report.wallet.deposit');
            $adminNotification->save();

            return response()->json(
                [
                    'success' => true,
                    'type' => 'success',
                    'wal_trx' => WalletsTransactions::where('user_id', $user->id)->where('symbol', $request->symbol)->orWhere('to', $request->symbol)->latest()->get(),
                    'message' => 'Deposit order placed successfully'
                ]
            );
        }
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'recieving_address' => 'required',
        ]);
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->where('provider', $this->provider)->where('type', 'trading')->where('symbol', $request->symbol)->first();
        $fee = getGen()->provider_withdraw_fee / 100;
        if (($request->amount * (1 + $fee)) >= $wallet->balance) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Your Withdraw Amount is higher than your balance!'
                ]
            );
        }

        $wallet->balance -= $request->amount + ($request->amount * $fee);
        $wallet->save();

        $withdraw = new ThirdpartyTransactions();
        $withdraw->user_id = $user->id;
        $withdraw->symbol = $request->symbol;
        $withdraw->recieving_address = $request->recieving_address;
        $withdraw->amount = $request->amount;
        if ($this->provider == 'coinbasepro') {
            $provider_withdraw = $this->api->withdraw($request->symbol, $request->amount, $request->recieving_address);
            $withdraw->fee = $provider_withdraw['info']['fee'];
            $withdraw->trx_id = $provider_withdraw['info']['id'];
        } else if ($this->provider == 'binance') {
            $provider_withdraw = $this->api->withdraw($request->symbol, $request->amount, $request->recieving_address, $request->memo, ['network' => $request->chain]);
            $withdraw->trx_id = $provider_withdraw['info']['id'];
        } else {
            $withdraw->memo = $request->memo;
            $withdraw->chain = $request->chain;
            $transfer_process = $this->api->transfer($request->symbol, $request->amount, 'spot', 'main');
            if (isset($transfer_process['info'])) {
                if (isset($transfer_process['info']['orderId'])) {
                    $provider_withdraw = $this->api->withdraw($request->symbol, $request->amount, $request->recieving_address, $request->memo, ['network' => $request->chain]);
                    if (isset($provider_withdraw['info']['withdrawalId'])) {
                        $withdraw_id = collect($this->api->fetch_withdrawals())->where('id', $provider_withdraw['info']['withdrawalId'])->first();
                        $withdraw->trx_id = $provider_withdraw['info']['withdrawalId'];
                        $withdraw->fee = ($request->amount * $fee) + $withdraw_id['fee']['cost'];
                    } else {
                        $withdraw_id = collect($this->api->fetch_withdrawals())->where('id', $provider_withdraw['id'])->first();
                        $withdraw->trx_id = $provider_withdraw['id'];
                        $withdraw->fee = ($request->amount * $fee) + $withdraw_id['fee']['cost'];
                    }
                } else if (isset($transfer_process['info']['data']['orderId'])) {
                    $provider_withdraw = $this->api->withdraw($request->symbol, $request->amount, $request->recieving_address, $request->memo, ['network' => $request->chain]);
                    if (isset($provider_withdraw['info']['data']['withdrawalId'])) {
                        $withdraw_id = collect($this->api->fetch_withdrawals())->where('id', $provider_withdraw['info']['data']['withdrawalId'])->first();
                        $withdraw->trx_id = $provider_withdraw['info']['data']['withdrawalId'];
                        $withdraw->fee = ($request->amount * $fee) + $withdraw_id['fee']['cost'];
                    } else {
                        $withdraw_id = collect($this->api->fetch_withdrawals())->where('id', $provider_withdraw['id'])->first();
                        $withdraw->trx_id = $provider_withdraw['id'];
                        $withdraw->fee = ($request->amount * $fee) + $withdraw_id['fee']['cost'];
                    }
                }
            }
        }
        $withdraw->type = '2';
        $withdraw->status = '0';
        $withdraw->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = getAmount($withdraw->amount);
        $transaction->post_balance = getAmount($wallet->balance);
        $transaction->charge = getAmount($request->amount + ($request->amount * $fee));
        $transaction->trx_type = '-';
        $transaction->details = 'Withdraw of ' . $withdraw->amount . ' ' . $withdraw->symbol . ' From Wallet: ' . $withdraw->recieving_address;
        $transaction->trx =  $withdraw->trx_id;
        $transaction->save();

        $wallet_new_trx = new WalletsTransactions();
        $wallet_new_trx->user_id = $withdraw->user_id;
        $wallet_new_trx->symbol = $withdraw->symbol;
        $wallet_new_trx->amount = $withdraw->amount;
        if ($this->provider == 'kucoin') {
            $wallet_new_trx->chain = $request->chain;
        } else if ($this->provider == 'binance') {
            $wallet_new_trx->chain = $request->chain;
        }
        $wallet_new_trx->charge = getAmount($request->amount + ($request->amount * $fee));
        if ($this->provider == 'binance') {
            $wallet_new_trx->amount_recieved = $wallet_new_trx->charge - $request->fee;
        } else {
            $wallet_new_trx->amount_recieved = $wallet_new_trx->charge - $withdraw->fee;
        }
        $wallet_new_trx->to = $withdraw->recieving_address;
        $wallet_new_trx->type = '2';
        $wallet_new_trx->status = '1';
        $wallet_new_trx->trx = $withdraw->trx_id;
        $wallet_new_trx->wallet_type = 'trading';
        $wallet_new_trx->details = 'Withdraw of ' . $withdraw->amount . ' ' . $withdraw->symbol . ' From Wallet: ' . $withdraw->recieving_address;
        if ($this->provider == 'binance') {
            $wallet_new_trx->fees = ($request->amount * $fee) + $request->fee;
        } else {
            $wallet_new_trx->fees = $withdraw->fee;
        }
        $wallet_new_trx->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New Withdraw From ' . $user->username;
        $adminNotification->click_url = route('admin.report.wallet.withdraw');
        $adminNotification->save();

        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'wal_trx' => WalletsTransactions::where('user_id', $user->id)->where('symbol', $request->symbol)->orWhere('to', $request->symbol)->latest()->get(),
                'wal' => $wallet,
                'message' => 'Withdraw order placed successfully'
            ]
        );
    }

    public function transfer_from_trading(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();

        if (Wallet::where('user_id', $user->id)->where('provider', 'funding')->where('symbol', $request->symbol)->exists() == true) {
            $from = Wallet::where('user_id', $user->id)->where('provider', $this->provider)->where('symbol', $request->symbol)->first();
            $to = Wallet::where('user_id', $user->id)->where('provider', 'funding')->where('symbol', $request->symbol)->first();
            if ($request->amount > $from->balance) {
                return response()->json(
                    [
                        'success' => true,
                        'type' => 'error',
                        'message' => 'Amount is higher than your wallet balance'
                    ]
                );
            } else {
                $transfer = new Transaction();
                $transfer->user_id = $user->id;
                $transfer->amount = getAmount($request->amount);
                $transfer->post_balance = getAmount($request->balance);
                $transfer->charge = getAmount($request->amount);
                $transfer->trx_type = '-';
                $transfer->details = 'Transfer of ' . $request->amount . ' ' . $request->symbol . ' from trading to funding wallet';
                $transfer->trx = getTrx();
                $transfer->save();

                $wallet_new_trx = new WalletsTransactions();
                $wallet_new_trx->user_id = $transfer->user_id;
                $wallet_new_trx->symbol = $request->symbol;
                $wallet_new_trx->amount = $transfer->amount;
                $wallet_new_trx->amount_recieved = $transfer->amount;
                $wallet_new_trx->charge = $request->amount;
                $wallet_new_trx->to = $to->address;
                $wallet_new_trx->type = '3';
                $wallet_new_trx->status = '1';
                $wallet_new_trx->trx = $transfer->trx;
                $wallet_new_trx->wallet_type = 'trading';
                $wallet_new_trx->details = 'Transfer of ' . $request->amount . ' ' . $request->symbol . ' from trading to funding wallet';
                $wallet_new_trx->save();

                $from->balance -= $request->amount;
                $from->save();
                $to->balance += $request->amount;
                $to->save();

                return response()->json(
                    [
                        'success' => true,
                        'type' => 'success',
                        'wal_trx' => WalletsTransactions::where('user_id', $user->id)->where('symbol', $request->symbol)->orWhere('to', $request->symbol)->latest()->get(),
                        'wal' => $from,
                        'message' => 'Balance Transferred Successfully'
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Create Funding Wallet first'
                ]
            );
        }
    }

    public function transfer_from_funding(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();
        if (Wallet::where('user_id', $user->id)->where('provider', $this->provider)->where('symbol', $request->symbol)->exists() == true) {
            $from = Wallet::where('user_id', $user->id)->where('provider', 'funding')->where('symbol', $request->symbol)->first();
            $to = Wallet::where('user_id', $user->id)->where('provider', $this->provider)->where('symbol', $request->symbol)->first();
            if ($request->amount > $from->balance) {
                return response()->json(
                    [
                        'success' => true,
                        'type' => 'error',
                        'message' => 'Amount is higher than your wallet balance'
                    ]
                );
            } else {
                $transfer = new Transaction();
                $transfer->user_id = $user->id;
                $transfer->amount = getAmount($request->amount);
                $transfer->post_balance = getAmount($request->balance);
                $transfer->charge = getAmount($request->amount);
                $transfer->trx_type = '-';
                $transfer->currency = $request->symbol;
                $transfer->details = 'Transfer of ' . $request->amount . ' ' . $request->symbol . ' from funding to trading wallet';
                $transfer->trx = getTrx();
                $transfer->save();
                $from->balance -= $request->amount;
                $from->save();

                $wallet_new_trx = new WalletsTransactions();
                $wallet_new_trx->user_id = $transfer->user_id;
                $wallet_new_trx->symbol = $request->symbol;
                $wallet_new_trx->amount = $transfer->amount;
                $wallet_new_trx->amount_recieved = $transfer->amount;
                $wallet_new_trx->charge = $request->amount;
                $wallet_new_trx->to = $to->address;
                $wallet_new_trx->type = '4';
                $wallet_new_trx->status = '2';
                $wallet_new_trx->trx = $transfer->trx;
                $wallet_new_trx->wallet_type = 'funding';
                $wallet_new_trx->details = 'Transfer of ' . $request->amount . ' ' . $request->symbol . ' from funding to trading wallet';
                $wallet_new_trx->save();

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'New Transfer From ' . $user->username;
                $adminNotification->click_url = route('admin.report.wallet.transfer.funding');
                $adminNotification->save();

                return response()->json(
                    [
                        'success' => true,
                        'type' => 'success',
                        'wal_trx' => WalletsTransactions::where('user_id', $user->id)->where('symbol', $request->symbol)->orWhere('to', $request->symbol)->latest()->get(),
                        'wal' => $from,
                        'message' => 'Balance Transfer Pending Approval'
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'error',
                    'message' => 'Create Funding Wallet first'
                ]
            );
        }
    }

    public function authenticate(Request $request)
    {
        $user = User::where('eth_address', $request->ethAddress)->firstOrFail();

        auth()->login($user);

        return true;
    }

    public function connect(Request $request)
    {
        $user = Auth::user();
        $user->forceFill([
            'eth_Address' => $request->ethAddress,
        ])->save();
        return 1;
    }

    public function disconnect(Request $request)
    {
        $user = Auth::user();
        $user->forceFill([
            'eth_Address' => null,
        ])->save();
        return 1;
    }

    public function regenerate(Request $request)
    {
        $user = Auth::user();
        $wallet = Wallet::where('provider', $this->provider)->where('user_id', $user->id)->where('type', 'trading')->where('symbol', $request->symbol)->first();
        if ($this->provider == 'kucoin') {
            $response = $this->api->public_get_currencies_currency(array('currency' => $request->symbol));
            $currency = $this->api->safe_value($response, 'data');
            $results = array();
            if ($currency) {
                $chains = $this->api->safe_value($currency, 'chains');
                if ((count($chains) > 1) && ($request->symbol !== 'BNB')) {
                    foreach ($chains as $chain) {
                        $chainName = $this->api->safe_string($chain, 'chainName');
                        $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName, $chainName);
                        if (!isset($results)) {
                            $results = array();
                        }
                        $results[$chainName] = $address;
                    }
                } elseif ((count($chains) > 1) && ($request->symbol == 'BNB')) {
                    $chainName = 'BEP2';
                    $results[$chainName] = $this->api->fetch_deposit_address('BNB');
                } else {
                    $chain = $this->api->safe_value($chains, 0);
                    $chainName = $this->api->safe_string($chain, 'chainName');
                    $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName);
                    if (!isset($results)) {
                        $results = array();
                    }
                    $results[$chainName] = $address;
                }
                $results = array_filter($results);
                $wallet->addresses = json_encode($results);
                $notify[] = ['success', 'Your ' . $wallet->symbol . ' Wallet Regenerated Successfully'];
                $wallet->save();
            } else {
                $notify[] = ['warning', 'Wallet Regeneration Failed, Please report to support'];
            }
        }
        return back()->withNotify($notify);
    }

    public function admincreateWallet(Request $request)
    {
        if (Wallet::where('provider', $this->provider)->where('user_id', $request->user_id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
            $notify[] = ['warning', 'You Have ' . $request->symbol . ' Wallet Already!'];
        } else {
            if ($request->type == 'trading') {
                $wallet = new Wallet();
                $wallet->user_id = $request->user_id;
                $wallet->provider = $this->provider;
                $wallet->symbol = $request->symbol;
                $wallet->type = 'trading';
                if ($this->provider == 'coinbasepro') {
                    try {
                        $wallet->address = $this->api->create_deposit_address($request->symbol)['address'];
                        $wallet->save();
                        $notify[] = ['success', $wallet->symbol . ' Wallet Created Successfully'];
                    } catch (Throwable $e) {
                        $notify[] = ['warning', 'Wallet Generation Failed, Please check your provider connection'];
                    }
                } else if ($this->provider == 'kucoin') {
                    $response = $this->api->public_get_currencies_currency(array('currency' => $request->symbol));
                    $currency = $this->api->safe_value($response, 'data');
                    $results = array();
                    if ($currency) {
                        $chains = $this->api->safe_value($currency, 'chains');
                        if ((count($chains) > 1) && ($request->symbol !== 'BNB')) {
                            foreach ($chains as $chain) {
                                $chainName = $this->api->safe_string($chain, 'chainName');
                                $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName, $chainName);
                                if (!isset($results)) {
                                    $results = array();
                                }
                                $results[$chainName] = $address;
                            }
                        } else {
                            $chain = $this->api->safe_value($chains, 0);
                            $chainName = $this->api->safe_string($chain, 'chainName');
                            $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName);
                            if (!isset($results)) {
                                $results = array();
                            }
                            $results[$chainName] = $address;
                        }
                        $results = array_filter($results);
                        $wallet->addresses = json_encode($results);
                        if (reset($results) != null) {
                            $wallet->address = reset($results)['address'];
                            $notify[] = ['success', $wallet->symbol . ' Wallet Created Successfully'];
                            $wallet->save();
                        } else {
                            $notify[] = ['warning', 'Wallet Generation Failed, No Address Created'];
                        }
                    } else {
                        $notify[] = ['warning', 'Wallet Generation Failed, Please check your provider connection'];
                    }
                }
            } else {
                if (Wallet::where('provider', 'funding')->where('user_id', $request->user_id)->where('type', $request->type)->where('symbol', $request->symbol)->first()) {
                    $notify[] = ['warning', 'You Have ' . $request->symbol . ' Wallet Already!'];
                } else {
                    $wallet = new Wallet();
                    $wallet->user_id = $request->user_id;
                    $wallet->symbol = $request->symbol;
                    $wallet->address = grs(34);
                    $wallet->type = 'funding';
                    $wallet->provider = 'funding';
                    $notify[] = ['success', 'Client ' . $wallet->symbol . ' Wallet Created Successfully'];
                    $wallet->save();
                }
            }
        }
        return back()->withNotify($notify);
    }

    public function adminregenerateWallet(Request $request)
    {
        $wallet = Wallet::where('provider', $this->provider)->where('user_id', $request->user_id)->where('type', 'trading')->where('symbol', $request->symbol)->first();
        if ($request->type == 'trading') {
            if ($this->provider == 'coinbasepro') {
                try {
                    $wallet->address = $this->api->create_deposit_address($request->symbol)['address'];
                    $wallet->save();
                    $notify[] = ['success', $wallet->symbol . ' Wallet Regenerated Successfully'];
                } catch (Throwable $e) {
                    $notify[] = ['warning', 'Wallet Regeneration Failed, Please check your provider connection'];
                }
            } else if ($this->provider == 'kucoin') {
                $response = $this->api->public_get_currencies_currency(array('currency' => $request->symbol));
                $currency = $this->api->safe_value($response, 'data');
                $results = array();
                if ($currency) {
                    $chains = $this->api->safe_value($currency, 'chains');
                    if ((count($chains) > 1) && ($request->symbol !== 'BNB')) {
                        foreach ($chains as $chain) {
                            $chainName = $this->api->safe_string($chain, 'chainName');
                            $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName, $chainName);
                            if (!isset($results)) {
                                $results = array();
                            }
                            $results[$chainName] = $address;
                        }
                    } else {
                        $chain = $this->api->safe_value($chains, 0);
                        $chainName = $this->api->safe_string($chain, 'chainName');
                        $address = $this->fetch_create_deposit_address($this->api, $request->symbol, $chainName);
                        if (!isset($results)) {
                            $results = array();
                        }
                        $results[$chainName] = $address;
                    }
                    $results = array_filter($results);
                    $wallet->addresses = json_encode($results);
                    if (reset($results) != null) {
                        $wallet->address = reset($results)['address'];
                        $notify[] = ['success', $wallet->symbol . ' Wallet Created Successfully'];
                        $wallet->save();
                    } else {
                        $notify[] = ['warning', 'Wallet Generation Failed, No Address Created'];
                    }
                } else {
                    $notify[] = ['warning', 'Wallet Regeneration Failed, Please check your provider connection'];
                }
            }
        } else {
            if (Wallet::where('provider', 'funding')->where('user_id', $request->user_id)->where('type', 'funding')->where('symbol', $request->symbol)->first()) {
                $notify[] = ['warning', 'Client Have ' . $request->symbol . ' Wallet Already!'];
            } else {
                $wallet->address = grs(34);
                $wallet->type = 'funding';
                $wallet->provider = 'funding';
                $notify[] = ['success', 'Client ' . $wallet->symbol . ' Wallet Regenerated Successfully'];
                $wallet->save();
            }
        }
        return back()->withNotify($notify);
    }
}
