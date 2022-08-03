<?php

namespace App\Http\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PracticeBalance extends Component
{
    protected $listeners = ['walletUpdated' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $practice_balance = number_format(($user->practice_balance + ($user->practice_balance_btc * getCoinRate('BTC'))) * getCurrency()->rate , 2);
        return view('livewire.partials.practice-balance', compact('practice_balance'));
    }
}
