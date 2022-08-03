<?php

namespace App\Http\Livewire\Wallet;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PracticeWalletExchange extends Component
{
    public $amount;
    public $from;

    public $towhat;
    protected $listeners = ['towhat' => 'render'];
    protected $rules = [
        'amount' => 'required|max:1000|numeric',
    ];
    protected $messages = [
        'amount.required' => 'The amount cannot be empty.',
        'amount.numeric' => 'The amount should be in numbers',
        'amount.invalid' => 'The amount is invalid',
    ];
    public function render()
    {
        $p_btc = getCoinRate('BTC');
        $from = $this->from;
        $to = $this->towhat;
        if($this->from == 'USD') {
            $to = 'BTC';
        } else {
            $to = 'USD';
        }
        return view('livewire.wallet.practice-wallet-exchange', compact('p_btc','from','to'));
    }

    public function practice()
    {
        $this->validate();

        $user = Auth::user();
        $fee = GeneralSetting::first()->exchange_fee / 100;
        $w_usd = $user->practice_balance;
        $w_btc = $user->practice_balance_btc;


        if ($this->from === 'USD') {
            if ($w_usd >= $this->amount) {
                $user->forceFill([
                    'practice_balance_btc' =>  $w_btc + ( ($this->amount / getCoinRate('BTC')) - ( ($this->amount / getCoinRate('BTC')) ) ),
                    'practice_balance' => $w_usd - $this->amount,
                ])->save();
                session()->flash('message_success', 'Exchanged Successfully');
                $this->emit('walletUpdated');
            } else {
                session()->flash('message_failed', 'Exchanged Failed');
            }
        } else {
            if ($w_btc > $this->amount) {
                $user->forceFill([
                    'practice_balance' => $w_usd + ( ($this->amount * getCoinRate('BTC')) - ( ($this->amount * getCoinRate('BTC')) * $fee ) ),
                    'practice_balance_btc' => $w_btc - $this->amount,
                ])->save();
                session()->flash('message_success', 'Exchanged Successfully');
                $this->emit('walletUpdated');
            } else {
                session()->flash('message_failed', 'Exchanged Failed');
            }
        }
    }
}
