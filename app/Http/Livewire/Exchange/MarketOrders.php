<?php

namespace App\Http\Livewire\Exchange;

use Livewire\Component;

class MarketOrders extends Component
{

    protected $listeners = ['refresh' => '$refresh'];
    public function render()
    {
        return view('livewire.exchange.market-orders');
    }
}
