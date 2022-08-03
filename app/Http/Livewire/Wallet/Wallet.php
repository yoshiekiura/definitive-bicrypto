<?php

namespace App\Http\Livewire\Wallet;

use App\Models\Platform;
use App\Models\Wallet as ModelsWallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wallet extends Component
{
    public function render()
    {
        $user = Auth::user();
        $wallets = ModelsWallet::where('user_id', $user->id)->where('provider','funding')->where('balance','!=','0')->orderBy('balance', 'DESC')->take(5)->get();
        if(ModelsWallet::where('user_id', $user->id)->where('symbol','USDT')->exists()) {
            $wal = ModelsWallet::where('user_id', $user->id)->where('provider','funding')->where('symbol','USDT')->first();
        } else {
            $wal = 'null';
        }
        return view('livewire.wallet.wallet',compact('wallets','wal'));
    }
}
