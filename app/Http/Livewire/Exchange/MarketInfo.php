<?php

namespace App\Http\Livewire\Exchange;

use Livewire\Component;

class MarketInfo extends Component
{
    public $provide;
    public $symbol;
    public $currency;
    protected $listeners = ['refresh' => '$refresh'];
    public function render()
    {
        $currency = $this->currency;
        $symbol = $this->symbol;
        $provide = $this->provide;
        return view('livewire.exchange.market-info', compact('currency', 'symbol', 'provide'));
    }
}
