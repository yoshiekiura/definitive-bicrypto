<?php

namespace App\Http\Livewire\Exchange;

use App\Models\ThirdpartyProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BalanceM extends Component
{
    public $symbol;
    public $currency;
    protected $listeners = ['refreshBalance' => '$refresh'];

    public function __construct()
    {
        if(ThirdpartyProvider::where('status',1)->exists()){
            $this->provider = ThirdpartyProvider::where('status',1)->first()->title;
        } else {
            $this->provider = 'funding';
        }
    }
    public function render()
    {
        $user = Auth::user();

        if(isWallet($user->id,'trading', $this->symbol,$this->provider) == true){
            $fromW = getWallet($user->id,'trading', $this->symbol,$this->provider);
            $from_balance = getAmount($fromW->balance);
        } else {
            $fromW = '0';
            $from_balance = 'Wallet Dont Exist';
        }
        if(isWallet($user->id,'trading', $this->currency,$this->provider) == true){
            $toW = getWallet($user->id,'trading', $this->currency,$this->provider);
            $to_balance = getAmount($toW->balance);
        } else {
            $toW = '0';
            $to_balance = 'Wallet Dont Exist';
        }
        return view('livewire.exchange.balance-m', compact('toW','fromW','from_balance','to_balance'));
    }
}
