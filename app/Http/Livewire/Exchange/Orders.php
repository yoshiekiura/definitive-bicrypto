<?php

namespace App\Http\Livewire\Exchange;

use App\Models\ThirdpartyOrders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    public $provider;
    public $symbol;
    protected $listeners = ['refreshBalance' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $orders = ThirdpartyOrders::where('user_id',$user->id)->where('symbol',$this->symbol)->where('provider',$this->provider)->where('status','closed')->orWhere('status','canceled')->latest()->limit(10)->get();
		$empty_message = "No Orders Found";
        return view('livewire.exchange.orders', compact('orders','empty_message'));
    }
}
