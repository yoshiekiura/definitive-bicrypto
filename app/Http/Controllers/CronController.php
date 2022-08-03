<?php

namespace App\Http\Controllers;

use App\Models\BinanceCurrencies;
use App\Models\Bot;
use App\Models\BotContract;
use App\Models\BybitCurrencies;
use App\Models\CoinbaseCurrencies;
use App\Models\TradeLog;
use App\Models\User;
use Carbon\Carbon;
use App\Models\PracticeLog;
use App\Models\Transaction;
use App\Models\GeneralSetting;
use App\Models\Extension;
use App\Models\ForexAccounts;
use App\Models\ForexInvestments;
use App\Models\ForexLogs;
use App\Models\KucoinCurrencies;
use App\Models\Markets;
use App\Models\MLM;
use App\Models\Pairs;
use App\Models\ScheduledOrders;
use App\Models\StakingCurrency;
use App\Models\StakingLog;
use App\Models\ThirdpartyOrders;
use App\Models\ThirdpartyProvider;
use App\Models\ThirdpartyTransactions;
use App\Models\WalletsTransactions;
use Throwable;

class CronController extends Controller
{
    public function __construct()
    {
        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
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
        $this->gnl = GeneralSetting::first();
        #$this->api->set_sandbox_mode('enable');
    }

    public function view()
    {
        $page_title = 'Cron Settings';
        $bot = Extension::where('id', 1)->first();
        $mlm = Extension::where('id', 3)->first();
        $forex = Extension::where('id', 4)->first();
        $staking = Extension::where('id', 6)->first();
        return view('admin.setting.cron', compact('page_title', 'bot', 'mlm', 'forex', 'staking'));
    }
    public function index()
    {
        $tradeLogs = TradeLog::where('status', 0)->where('in_time', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($tradeLogs as $tradeLog) {
            $cryptoRate = getCoinRate($tradeLog->symbol);
            $user = User::find($tradeLog->user_id);
            $wallet = getWallet($tradeLog->user_id, 'funding', $tradeLog->pair, 'funding');
            if ($tradeLog->result == 0) {

                if ($tradeLog->hilow == 1) {
                    if ($tradeLog->price_was < $cryptoRate) {
                        $wallet->balance +=  $tradeLog->amount + $tradeLog->margin;
                        $wallet->save();

                        $tradeLogAmount = $tradeLog->amount + $tradeLog->margin;
                        $details = 'Trade ' . $tradeLog->symbol . ' ' . "WIN";
                        $this->transactions($wallet, $tradeLogAmount, $details);
                        $tradeLog->result = 1;
                    } else if ($tradeLog->price_was > $cryptoRate) {
                        $tradeLog->result = 2;
                    } else {
                        $wallet->balance += $tradeLog->amount;
                        $wallet->save();

                        $tradeLogAmount = $tradeLog->amount;
                        $details = 'Trade ' . $tradeLog->symbol . ' ' .  "Refund";
                        $this->transactions($wallet, $tradeLogAmount, $details);
                        $tradeLog->result = 3;
                    }
                } else if ($tradeLog->hilow == 2) {
                    if ($tradeLog->price_was > $cryptoRate) {
                        $wallet->balance += $tradeLog->amount + $tradeLog->margin;
                        $wallet->save();

                        $tradeLogAmount = $tradeLog->amount + $tradeLog->margin;
                        $details = 'Trade ' . $tradeLog->symbol . ' ' . "WIN";
                        $this->transactions($wallet, $tradeLogAmount, $details);
                        $tradeLog->result = 1;
                    } else if ($tradeLog->price_was < $cryptoRate) {
                        $tradeLog->result = 2;
                    } else {
                        $wallet->balance += $tradeLog->amount;
                        $wallet->save();

                        $tradeLogAmount = $tradeLog->amount;
                        $details = 'Trade ' . $tradeLog->symbol . ' ' .  "Refund";
                        $this->transactions($wallet, $tradeLogAmount, $details);
                        $tradeLog->result = 3;
                    }
                }
                $tradeLog->status = 1;
                $tradeLog->save();
            }
        }
    }

    public function transactions($wallet, $tradeLogAmount, $details)
    {
        $transaction = new Transaction();
        $transaction->user_id = $wallet->user_id;
        $transaction->amount = $tradeLogAmount;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type = "+";
        $transaction->details = $details;
        $transaction->trx = getTrx();
        $transaction->save();
    }

    public function practiceCron()
    {
        $practiceLogs = PracticeLog::where('status', 0)->where('in_time', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($practiceLogs as $practiceLog) {
            $cryptoRate = getCoinRate($practiceLog->symbol);
            $user = User::find($practiceLog->user_id);
            if ($practiceLog->result == 0) {
                if ($practiceLog->hilow == 1) {
                    if ($practiceLog->price_was < $cryptoRate) {
                        $user->practice_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                        $user->save();

                        $practiceLog->result = 1;
                    } else if ($practiceLog->price_was > $cryptoRate) {
                        $practiceLog->result = 2;
                    } else {
                        $user->practice_balance += $practiceLog->amount;
                        $user->save();

                        $practiceLog->result = 3;
                    }
                } else if ($practiceLog->hilow == 2) {
                    if ($practiceLog->price_was > $cryptoRate) {
                        $user->practice_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                        $user->save();
                        $practiceLog->result = 1;
                    } else if ($practiceLog->price_was < $cryptoRate) {
                        $practiceLog->result = 2;
                    } else {
                        $user->practice_balance += $practiceLog->amount;
                        $user->save();
                        $practiceLog->result = 3;
                    }
                }
                $practiceLog->status = 1;
                $practiceLog->save();
            }
        }
    }
    public function scheduledOrdersCron()
    {
        $Logs = ScheduledOrders::where('status', 0)->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($Logs as $Log) {
            $marketRate = getCoinRate($Log->market);
            $pairRate = getCoinRate($Log->pair);

            if ($Log->account == 1) #practice
            {
                if ($Log->type == 1) #rise
                {
                    if ($Log->method == 1) #higher_than
                    {
                        if (($marketRate / $pairRate) > $Log->price) {
                            $practiceLog = new PracticeLog();
                            $practiceLog->user_id = $Log->user_id;
                            $practiceLog->symbol = $Log->symbol;
                            $practiceLog->pair = $Log->pair;
                            $practiceLog->amount = $Log->amount;
                            $practiceLog->margin = $Log->margin;
                            $practiceLog->duration = $Log->duration;
                            $practiceLog->in_time = $Log->in_time;
                            $practiceLog->hilow = '1';
                            $practiceLog->price_was = getCoinRate($Log->market);
                            $practiceLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    } else {
                        if (($marketRate / $pairRate) < $Log->price) {
                            $practiceLog = new PracticeLog();
                            $practiceLog->user_id = $Log->user_id;
                            $practiceLog->symbol = $Log->symbol;
                            $practiceLog->pair = $Log->pair;
                            $practiceLog->amount = $Log->amount;
                            $practiceLog->margin = $Log->margin;
                            $practiceLog->duration = $Log->duration;
                            $practiceLog->in_time = $Log->in_time;
                            $practiceLog->hilow = '1';
                            $practiceLog->price_was = getCoinRate($Log->market);
                            $practiceLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    }
                } else {
                    if ($Log->method == 1) #higher_than
                    {
                        if (($marketRate / $pairRate) > $Log->price) {
                            $practiceLog = new PracticeLog();
                            $practiceLog->user_id = $Log->user_id;
                            $practiceLog->symbol = $Log->symbol;
                            $practiceLog->pair = $Log->pair;
                            $practiceLog->amount = $Log->amount;
                            $practiceLog->margin = $Log->margin;
                            $practiceLog->duration = $Log->duration;
                            $practiceLog->in_time = $Log->in_time;
                            $practiceLog->hilow = '2';
                            $practiceLog->price_was = getCoinRate($Log->market);
                            $practiceLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    } else {
                        if (($marketRate / $pairRate) < $Log->price) {
                            $practiceLog = new PracticeLog();
                            $practiceLog->user_id = $Log->user_id;
                            $practiceLog->symbol = $Log->symbol;
                            $practiceLog->pair = $Log->pair;
                            $practiceLog->amount = $Log->amount;
                            $practiceLog->margin = $Log->margin;
                            $practiceLog->duration = $Log->duration;
                            $practiceLog->in_time = $Log->in_time;
                            $practiceLog->hilow = '2';
                            $practiceLog->price_was = getCoinRate($Log->market);
                            $practiceLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    }
                }
            } else {
                if ($Log->type == 1) #rise
                {
                    if ($Log->method == 1) #higher_than
                    {
                        if (($marketRate / $pairRate) > $Log->price) {
                            $tradeLog = new TradeLog();
                            $tradeLog->user_id = $Log->user_id;
                            $tradeLog->symbol = $Log->symbol;
                            $tradeLog->pair = $Log->pair;
                            $tradeLog->amount = $Log->amount;
                            $tradeLog->margin = $Log->margin;
                            $tradeLog->duration = $Log->duration;
                            $tradeLog->in_time = $Log->in_time;
                            $tradeLog->hilow = '1';
                            $tradeLog->price_was = getCoinRate($Log->market);
                            $tradeLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    } else {
                        if (($marketRate / $pairRate) < $Log->price) {
                            $tradeLog = new TradeLog();
                            $tradeLog->user_id = $Log->user_id;
                            $tradeLog->symbol = $Log->symbol;
                            $tradeLog->pair = $Log->pair;
                            $tradeLog->amount = $Log->amount;
                            $tradeLog->margin = $Log->margin;
                            $tradeLog->duration = $Log->duration;
                            $tradeLog->in_time = $Log->in_time;
                            $tradeLog->hilow = '1';
                            $tradeLog->price_was = getCoinRate($Log->market);
                            $tradeLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    }
                } else {
                    if ($Log->method == 1) #higher_than
                    {
                        if (($marketRate / $pairRate) > $Log->price) {
                            $tradeLog = new TradeLog();
                            $tradeLog->user_id = $Log->user_id;
                            $tradeLog->symbol = $Log->symbol;
                            $tradeLog->pair = $Log->pair;
                            $tradeLog->amount = $Log->amount;
                            $tradeLog->margin = $Log->margin;
                            $tradeLog->duration = $Log->duration;
                            $tradeLog->in_time = $Log->in_time;
                            $tradeLog->hilow = '2';
                            $tradeLog->price_was = getCoinRate($Log->market);
                            $tradeLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    } else {
                        if (($marketRate / $pairRate) < $Log->price) {
                            $tradeLog = new TradeLog();
                            $tradeLog->user_id = $Log->user_id;
                            $tradeLog->symbol = $Log->symbol;
                            $tradeLog->pair = $Log->pair;
                            $tradeLog->amount = $Log->amount;
                            $tradeLog->margin = $Log->margin;
                            $tradeLog->duration = $Log->duration;
                            $tradeLog->in_time = $Log->in_time;
                            $tradeLog->hilow = '2';
                            $tradeLog->price_was = getCoinRate($Log->market);
                            $tradeLog->save();
                            $scheduled = ScheduledOrders::where('id', $Log->id)->first();
                            $scheduled->status = '1';
                            $scheduled->save();
                        }
                    }
                }
            }
        }
    }

    public function botResult()
    {
        $bot_contracts = BotContract::where('status', 2)->where('end_date', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($bot_contracts as $bot_contract) {
            $wallet = getWallet($bot_contract->user_id, 'funding', $bot_contract->pair, 'funding');
            if ($bot_contract->result == 4) {
                $wallet->balance += $bot_contract->amount + $bot_contract->profit;
                $wallet->save();
                $bot_contract->result = 1;
                $bot_contract->status = 1;
                $bot_contract->save();
            } else if ($bot_contract->result == 5) {
                $wallet->balance += $bot_contract->amount - $bot_contract->profit;
                $wallet->save();
                $bot_contract->result = 2;
                $bot_contract->status = 1;
                $bot_contract->save();
            } else if ($bot_contract->result == 6) {
                $wallet->balance += $bot_contract->amount;
                $wallet->save();
                $bot_contract->result = 3;
                $bot_contract->status = 1;
                $bot_contract->save();
            }
        }
    }
    public function botMissed()
    {
        $bot_contracts = BotContract::where('status', 0)->where('end_date', '>', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($bot_contracts as $bot_contract) {
            $bot = Bot::where('id', $bot_contract->bot_id)->first();
            if ($bot->result_missed == 1) {
                $bot_contract->result = 4;
                $bot_contract->status = 2;
                $bot_contract->profit = $bot_contract->amount * ($bot->profit_missed / 100);
                $bot_contract->save();
            } else if ($bot->result_missed == 2) {
                $bot_contract->result = 5;
                $bot_contract->status = 2;
                $bot_contract->profit = $bot_contract->amount * ($bot->profit_missed / 100);
                $bot_contract->save();
            } else if ($bot->result_missed == 3) {
                $bot_contract->result = 6;
                $bot_contract->status = 2;
                $bot_contract->profit = '0';
                $bot_contract->save();
            }
        }
    }

    public function ForexResult()
    {
        $forex_logs = ForexLogs::where('status', 2)->where('end_date', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($forex_logs as $forex_log) {
            $account = ForexAccounts::where('user_id', $forex_log->user_id)->first();
            if ($forex_log->result == 4) {
                $account->balance += $forex_log->amount + $forex_log->profit;
                $account->save();
                $forex_log->result = 1;
                $forex_log->status = 1;
                $forex_log->save();
            } else if ($forex_log->result == 5) {
                $account->balance += $forex_log->amount - $forex_log->profit;
                $account->save();
                $forex_log->result = 2;
                $forex_log->status = 1;
                $forex_log->save();
            } else if ($forex_log->result == 6) {
                $account->balance += $forex_log->amount;
                $account->save();
                $forex_log->result = 3;
                $forex_log->status = 1;
                $forex_log->save();
            }
        }
    }
    public function ForexMissed()
    {
        $forex_logs = ForexLogs::where('status', 0)->where('end_date', '>', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach ($forex_logs as $forex_log) {
            $forex = ForexInvestments::where('id', $forex_log->investment_id)->first();
            if ($forex->result_missed == 1) {
                $forex_log->result = 4;
                $forex_log->status = 2;
                $forex_log->profit = $forex_log->amount * ($forex->profit_missed / 100);
                $forex_log->save();
            } else if ($forex->result_missed == 2) {
                $forex_log->result = 5;
                $forex_log->status = 2;
                $forex_log->profit = $forex_log->amount * ($forex->profit_missed / 100);
                $forex_log->save();
            } else if ($forex->result_missed == 3) {
                $forex_log->result = 6;
                $forex_log->status = 2;
                $forex_log->profit = '0';
                $forex_log->save();
            }
        }
    }
    public function mlmRanks()
    {
        $mlms = MLM::get();

        foreach ($mlms as $mlm) {
            if ($mlm->left != null && $mlm->right != null) {
                $mlm1A = MLM::where('username', $mlm->left)->first();
                $mlm1B = MLM::where('username', $mlm->right)->first();
                if ($mlm1A->rank == 0 && $mlm1B->rank == 0) {
                    $mlm->rank = 1;
                } else if ($mlm1A->rank == 1 && $mlm1B->rank == 1) {
                    $mlm->rank = 2;
                } else if ($mlm1A->rank == 2 && $mlm1B->rank == 2) {
                    $mlm->rank = 3;
                } else if ($mlm1A->rank == 3 && $mlm1B->rank == 3) {
                    $mlm->rank = 4;
                } else if ($mlm1A->rank == 4 && $mlm1B->rank == 4) {
                    $mlm->rank = 5;
                } else if ($mlm1A->rank == 5 && $mlm1B->rank == 5) {
                    $mlm->rank = 6;
                }
                $mlm->save();
            } else {
                $mlm->rank = 0;
                $mlm->save();
            }
        }
    }

    public function marketsToTable()
    {
        if ($this->provider != null) {
            $markets = $this->api->fetch_markets();
            $datas = [];
            if ($this->provider == 'bybit') {
                foreach ($markets as $market) {
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['symbol'] = $market['base'] . '/' . $market['quote'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['currency'] = $market['base'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['pair'] = $market['quote'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['type'] = $market['type'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['maker'] = $market['maker'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['taker'] = $market['taker'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['min_amount'] = $market['limits']['amount']['min'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['max_amount'] = $market['limits']['amount']['max'];
                    $datas[$this->provider][$market['quote']][$market['base'] . '/' . $market['quote']]['status'] = 1;
                }
            } else {
                foreach ($markets as $market) {
                    $datas[$this->provider][$market['quote']][$market['symbol']]['symbol'] = $market['symbol'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['currency'] = $market['base'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['pair'] = $market['quote'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['type'] = $market['type'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['maker'] = $market['maker'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['taker'] = $market['taker'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['min_amount'] = $market['limits']['amount']['min'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['max_amount'] = $market['limits']['amount']['max'];
                    $datas[$this->provider][$market['quote']][$market['symbol']]['status'] = 1;
                }
            }
            $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
            file_put_contents(public_path('data/markets/markets.json'), stripslashes($newJsonString));
        }
    }

    public function marketsClean()
    {
        if ($this->provider != null) {
            if (Markets::where('provider', $this->provider)->exists()) {
                $markets = Markets::where('provider', $this->provider)->get();
                foreach ($markets as $market) {
                    $market->delete();
                }
            }
        }
    }

    public function pairsToTable()
    {
        if ($this->provider != null) {
            $pairs =  Pairs::where('provider', $this->provider)->pluck('symbol');
            foreach ($pairs as $pair) {
                if (Pairs::where('provider', $this->provider)->where('symbol', $pair)->exists()) {
                    $currency = Pairs::where('provider', $this->provider)->where('symbol', $pair)->first();
                    $currency->symbol = $pair;
                    try {
                        $currency->status = 1;
                        $currency->save();
                    } catch (Throwable $e) {
                        $currency->status = 0;
                        $currency->save();
                    }
                }
            }
        }
    }

    public function currencies()
    {
        if ($this->provider != null) {
            $pairs =  Pairs::where('provider', $this->provider)->get();
            if ($this->provider == 'coinbasepro') {
                $currencies = CoinbaseCurrencies::get();
            } else if ($this->provider == 'binance') {
                $currencies = BinanceCurrencies::get();
            } else if ($this->provider == 'kucoin') {
                $currencies = KucoinCurrencies::get();
            } else if ($this->provider == 'bybit') {
                $currencies = BybitCurrencies::get();
            }
            foreach ($pairs as $pair) {
                foreach ($currencies as $currency) {
                    if ($currency->symbol == $pair->symbol) {
                        $currency->status = $pair->status;
                        $currency->save();
                    }
                }
            }
        }
    }

    public function currenciesToTable()
    {
        if ($this->provider != null) {
            if ($this->provider == 'coinbasepro') {
                $markets = arrayToObject($this->api->fetch_currencies());
                foreach ($markets as $market) {
                    if (CoinbaseCurrencies::where('symbol', $market->code)->exists()) {
                        $currency = CoinbaseCurrencies::where('symbol', $market->code)->first();
                        $currency->name = $market->info->name;
                        if ($market->info->status == 'online') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        $currency->type = $market->info->details->type;
                        $currency->network_confirmations = $market->info->details->network_confirmations;
                        $currency->sort_order = $market->info->details->sort_order;
                        $currency->crypto_address_link = $market->info->details->crypto_address_link;
                        $currency->crypto_transaction_link = $market->info->details->crypto_transaction_link;
                        $currency->min_withdrawal_amount = $market->info->details->min_withdrawal_amount;
                        $currency->max_withdrawal_amount = $market->info->details->max_withdrawal_amount;
                        $currency->save();
                    } else {
                        $currency = new CoinbaseCurrencies();
                        $currency->symbol = $market->code;
                        $currency->name = $market->info->name;
                        if ($market->info->status == 'online') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        $currency->type = $market->info->details->type;
                        $currency->network_confirmations = $market->info->details->network_confirmations;
                        $currency->sort_order = $market->info->details->sort_order;
                        $currency->crypto_address_link = $market->info->details->crypto_address_link;
                        $currency->crypto_transaction_link = $market->info->details->crypto_transaction_link;
                        $currency->min_withdrawal_amount = $market->info->details->min_withdrawal_amount;
                        $currency->max_withdrawal_amount = $market->info->details->max_withdrawal_amount;
                        $currency->save();
                    }
                }
            } else if ($this->provider == 'bybit') {
                $markets = $this->api->fetch_currencies();
                foreach ($markets as $market) {
                    if (BybitCurrencies::where('symbol', $market['code'])->exists()) {
                        $currency = BybitCurrencies::where('symbol', $market['code'])->first();
                        $currency->name = $market['name'];
                        $currency->status = 1;
                        $currency->networks = json_encode($market['networks']);
                        $currency->save();
                    } else {
                        $currency = new BybitCurrencies();
                        $currency->name = $market['name'];
                        $currency->symbol = $market['code'];
                        $currency->status = 1;
                        $currency->networks = json_encode($market['networks']);
                        $currency->save();
                    }
                }
            } else if ($this->provider == 'binance') {
                $markets = arrayToObject($this->api->fetch_currencies());
                foreach ($markets as $market) {
                    if (BinanceCurrencies::where('symbol', $market->code)->exists()) {
                        $currency = BinanceCurrencies::where('symbol', $market->code)->first();
                        $currency->name = $market->name;
                        if ($market->active == 'true') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        if ($market->deposit == 'true') {
                            $currency->deposit = '1';
                        } else {
                            $currency->deposit = '0';
                        }
                        if ($market->withdraw == 'true') {
                            $currency->withdraw = '1';
                        } else {
                            $currency->withdraw = '0';
                        }
                        $currency->fees = json_encode($market->fees);
                        $currency->networks = json_encode($market->networks);
                        $currency->save();
                    } else {
                        $currency = new BinanceCurrencies();
                        $currency->symbol = $market->code;
                        $currency->name = $market->name;
                        if ($market->active == 'true') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        if ($market->deposit == 'true') {
                            $currency->deposit = '1';
                        } else {
                            $currency->deposit = '0';
                        }
                        if ($market->withdraw == 'true') {
                            $currency->withdraw = '1';
                        } else {
                            $currency->withdraw = '0';
                        }
                        $currency->fees = json_encode($market->fees);
                        $currency->networks = json_encode($market->networks);
                        $currency->save();
                    }
                }
            } else if ($this->provider == 'kucoin') {
                $markets = arrayToObject($this->api->fetch_currencies());
                foreach ($markets as $market) {
                    if (KucoinCurrencies::where('symbol', $market->code)->exists()) {
                        $currency = KucoinCurrencies::where('symbol', $market->code)->first();
                        $currency->name = $market->name;
                        $currency->type = 'crypto';
                        $currency->network_confirmations = $market->info->confirms;
                        $currency->min_withdrawal_amount = $market->info->withdrawalMinSize;
                        $currency->fee = $market->info->withdrawalMinFee;
                        if ($market->active == 'true') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        if ($market->deposit == 'true') {
                            $currency->deposit = '1';
                        } else {
                            $currency->deposit = '0';
                        }
                        if ($market->withdraw == 'true') {
                            $currency->withdraw = '1';
                        } else {
                            $currency->withdraw = '0';
                        }
                        $currency->save();
                    } else {
                        $currency = new KucoinCurrencies();
                        $currency->symbol = $market->code;
                        $currency->name = $market->name;
                        $currency->type = 'crypto';
                        $currency->network_confirmations = $market->info->confirms;
                        $currency->min_withdrawal_amount = $market->info->withdrawalMinSize;
                        $currency->fee = $market->info->withdrawalMinFee;
                        if ($market->active == 'true') {
                            $currency->status = '1';
                        } else {
                            $currency->status = '0';
                        }
                        if ($market->deposit == 'true') {
                            $currency->deposit = '1';
                        } else {
                            $currency->deposit = '0';
                        }
                        if ($market->withdraw == 'true') {
                            $currency->withdraw = '1';
                        } else {
                            $currency->withdraw = '0';
                        }
                        $currency->save();
                    }
                }
            }
        }
    }

    public function fetch_deposits()
    {
        if ($this->provider != null) {
            $transactions = ThirdpartyTransactions::where('type', 1)->where('status', 0)->orWhere('status', 2)->get();
            if ($this->provider == 'kucoin') {
                $collections = collect($this->api->fetch_deposits());
            } else if ($this->provider == 'coinbasepro') {
                $collections = collect($this->api->fetch_transactions());
            } else if ($this->provider == 'binance') {
                $collections = collect($this->api->fetch_deposits());
            }
            foreach ($transactions as $transaction) {
                $req = $collections->where('txid', $transaction->address)->first();
                if ($req != null && $req['status'] == 'ok') {
                    if ($this->provider == 'kucoin') {
                        $wal_trx = WalletsTransactions::where('address', $transaction->address)->first();
                        $wal_trx->amount = $req['amount'];
                        $wal_trx->amount_recieved = $req['amount'];
                        $wal_trx->charge = $req['amount'] + $req['fee']['cost'];
                        if ($req['info']['status'] == 'PROCESSING') {
                            $transaction->status = 2;
                            $wal_trx->status = 2;
                        } else {
                            $transaction->status = 1;
                            $wallet = getWallet($transaction->user_id, 'trading', $transaction->symbol, $this->provider);
                            $wallet->balance += $req['amount'];
                            $wallet->save();
                            $wal_trx->status = 1;
                        }
                        $wal_trx->save();
                        $transaction->amount = $req['amount'];
                        $transaction->fee = $req['fee']['cost'];
                        $transaction->save();
                        $this->api->transfer($transaction->symbol, $req['amount'], 'main', 'trading');
                    } else {
                        $wal_trx = WalletsTransactions::where('user_id', $transaction->user_id)->where('address', $transaction->address)->first();
                        $wal_trx->amount = $req['amount'];
                        $wal_trx->amount_recieved = $req['amount'];
                        $wal_trx->charge = $req['amount'];
                        $wal_trx->status = 1;
                        $wal_trx->save();
                        if ($wal_trx->save()) {
                            $transaction->status = 1;
                            $transaction->amount = $req['amount'];
                            if ($req['fee'] != null) {
                                $transaction->fee = $req['fee']['cost'];
                            }
                            $transaction->save();
                            if ($transaction->save()) {
                                $wallet = getWallet($transaction->user_id, 'trading', $transaction->symbol, $this->provider);
                                $wallet->balance += $req['amount'];
                                $wallet->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function fetch_order()
    {
        if ($this->provider != null) {
            $transactions = ThirdpartyOrders::where('provider', $this->provider)->where('status', '!=', 'closed')->get();
            foreach ($transactions as $transaction) {
                $trx = $this->api->fetch_order($transaction->order_id);
                if ($transaction->status == 'open') {
                    if ($trx != null && $trx['remaining'] == 0 && $trx['price'] != null) {
                        $transaction->status = $trx['status'];
                        $transaction->filled = $trx['filled'];
                        $transaction->remaining = $trx['remaining'];
                        $transaction->price = $trx['price'];
                        $transaction->cost = $trx['cost'];
                        $transaction->fee = $trx['fee']['cost'];
                        $transaction->save();
                        if ($trx['side'] == 'buy') {
                            try {
                                $wal = getWallet($transaction->user_id, 'trading', getPair($transaction->symbol)['0'], $transaction->provider);
                                if ($wal) {
                                    $wal->balance += $trx['amount'];
                                    $wal->save();
                                }
                            } catch (\Throwable $th) {
                            }
                        } else if ($trx['side'] == 'sell') {
                            try {
                                $wal = getWallet($transaction->user_id, 'trading', getPair($transaction->symbol)['1'], $transaction->provider);
                                if ($wal) {
                                    $wal->balance += $trx['cost'];
                                    $wal->save();
                                }
                            } catch (\Throwable $th) {
                            }
                        }
                    } else if ($trx['remaining'] != 0) {
                        $transaction->status = 'filling';
                        $transaction->save();
                    }
                } else if ($transaction->status == 'filling') {
                    if ($trx != null && $trx['remaining'] == 0 && $trx['price'] != null) {
                        $transaction->status = $trx['status'];
                        $transaction->filled = $trx['filled'];
                        $transaction->remaining = $trx['remaining'];
                        $transaction->price = $trx['price'];
                        $transaction->cost = $trx['cost'];
                        $transaction->fee = $trx['fee']['cost'];
                        $transaction->save();
                        if ($trx['side'] == 'buy') {
                            try {
                                $wal = getWallet($transaction->user_id, 'trading', getPair($transaction->symbol)['0'], $transaction->provider);
                                if ($wal) {
                                    $wal->balance += $trx['amount'];
                                    $wal->save();
                                }
                            } catch (\Throwable $th) {
                            }
                        } else if ($trx['side'] == 'sell') {
                            try {
                                $wal = getWallet($transaction->user_id, 'trading', getPair($transaction->symbol)['1'], $transaction->provider);
                                if ($wal) {
                                    $wal->balance += $trx['cost'];
                                    $wal->save();
                                }
                            } catch (\Throwable $th) {
                            }
                        }
                    } else if ($trx['remaining'] != 0) {
                        $transaction->status = 'filling';
                        $transaction->save();
                    }
                } else if ($trx != null && $trx['status'] == 'canceled') {
                    $transaction->status = 'canceled';
                    $transaction->save();
                }
            }
        }
    }

    public function staking_profit()
    {
        $stakeCoins = StakingCurrency::where('status', 1)->get();
        foreach ($stakeCoins as $coin) {
            $stakeLog = StakingLog::where('coin_id', $coin->id)->where('status', 1)->first();
            $stakeLog->last_profit = $stakeLog->cost * ($coin->daily_profit / 100);
            $stakeLog->total_profit += $stakeLog->last_profit;
            if (Carbon::now() > $stakeLog->end_date) {
                $stakeLog->status = 2;
            }
            $stakeLog->save();
        }
    }
}
