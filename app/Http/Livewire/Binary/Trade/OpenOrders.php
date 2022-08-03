<?php

namespace App\Http\Livewire\Binary\Trade;

use App\Models\TradeLog;
use Livewire\Component;

class OpenOrders extends Component
{
    public $symbol;
    public $currency;
    protected $listeners = ['refreshBalance' => '$refresh'];
    public function render()
    {
        $orders = TradeLog::where('user_id',auth()->user()->id)->where('symbol',$this->symbol)->where('pair',$this->currency)->where('status',0)->latest()->limit(10)->get();
		$empty_message = "No Orders Found";
        return view('livewire.binary.trade.open-orders', compact('orders','empty_message'));
    }
}
