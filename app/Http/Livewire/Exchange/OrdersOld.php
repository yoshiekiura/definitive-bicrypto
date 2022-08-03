<?php

namespace App\Http\Livewire\Exchange;

use App\Models\ThirdpartyOrders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrdersOld extends Component
{
    public $provider;
    protected $listeners = ['refreshBalance' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $orders = ThirdpartyOrders::where('provider',$this->provider)->where('user_id',$user->id)->latest()->limit(10)->get();
		$empty_message = "No Orders Found";
        return view('livewire.exchange.orders-old', compact('orders','empty_message'));
    }
}
