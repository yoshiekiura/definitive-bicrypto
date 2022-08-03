<?php

namespace App\Http\Livewire\Binary\Trade;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Balance extends Component
{
    public $symbol;
    public $currency;
    protected $listeners = ['refreshBalance' => '$refresh'];

    public function render()
    {
        $user = Auth::user();
        $toW = getWallet($user->id,'funding', $this->currency,'funding');
        return view('livewire.binary.trade.balance', compact('toW'));
    }
}
