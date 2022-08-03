<?php

namespace App\Http\Livewire\Partials;

use App\Models\Wallet;
use Livewire\Component;

class FundingWallet extends Component
{
    protected $listeners = ['walletUpdated' => '$refresh'];
    public function render()
    {
        $wallets = Wallet::where('provider','funding')->where('user_id', auth()->user()->id)->where('balance','!=','0')->get();
        $total_balance = 0;
        foreach ($wallets as $wallet){
            $total_balance += $wallet->balance * getCoinRate($wallet->symbol);
        }
        $balance = getAmount($total_balance * getCurrency()->rate);
        return view('livewire.partials.funding-wallet',compact('balance'));
    }
}
