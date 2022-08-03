<?php

namespace App\Http\Livewire\Wallet;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WalletExchange extends Component
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
        return view('livewire.wallet.wallet-exchange', compact('p_btc','from','to'));
    }

    public function exchange()
    {
        $this->validate();

        $user = Auth::user();
        $fee = GeneralSetting::first()->exchange_fee / 100;
        $w_usd = $user->balance;
        $w_btc = $user->balance_btc;


        if ($this->from === 'USD') {
            if ($w_usd >= $this->amount) {
                $user->forceFill([
                    'balance_btc' =>  $w_btc + ( ($this->amount / getCoinRate('BTC')) - ( ($this->amount / getCoinRate('BTC')) ) ),
                    'balance' => $w_usd - $this->amount,
                ])->save();
                session()->flash('message_success', 'Exchanged Successfully');
                $this->emit('walletUpdated');
            } else {
                $this->addError('amount.invalid', 'The amount is invalid');
            }
        } else {
            if ($w_btc > $this->amount) {
                $user->forceFill([
                    'balance' => $w_usd + ( ($this->amount * getCoinRate('BTC')) - ( ($this->amount * getCoinRate('BTC')) * $fee ) ),
                    'balance_btc' => $w_btc - $this->amount,
                ])->save();
                session()->flash('message_success', 'Exchanged Successfully');
                $this->emit('walletUpdated');
            } else {
                $this->addError('amount.invalid', 'The amount is invalid');
            }
        }
    }
}
