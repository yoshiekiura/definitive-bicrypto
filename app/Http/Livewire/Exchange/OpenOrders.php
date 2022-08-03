<?php

namespace App\Http\Livewire\Exchange;

use App\Models\ThirdpartyOrders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OpenOrders extends Component
{
    public $provider;
    public $symbol;
    protected $listeners = ['refreshBalance' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $orders = ThirdpartyOrders::where('user_id',$user->id)->where('provider',$this->provider)->where('symbol',$this->symbol)->where('status','open')->orWhere('status','filling')->latest()->limit(10)->get();
        $empty_message = "No Orders Found";
        return view('livewire.exchange.open-orders', compact('orders','empty_message'));
    }
}
