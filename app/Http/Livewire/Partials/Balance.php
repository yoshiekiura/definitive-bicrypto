<?php

namespace App\Http\Livewire\Partials;

use App\Models\Currencies;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Balance extends Component
{
    protected $listeners = ['walletUpdated' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $wallets = Wallet::where('provider','funding')->where('user_id', $user->id)->where('balance','!=','0')->get();
        $total_balance = 0;
        foreach ($wallets as $wallet){
            $total_balance += $wallet->balance * getCoinRate($wallet->symbol);
        }
        $balance = getAmount($total_balance * getCurrency()->rate);
        return view('livewire.partials.balance', compact('balance'));
    }
}
