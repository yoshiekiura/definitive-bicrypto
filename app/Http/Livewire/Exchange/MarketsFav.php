<?php

namespace App\Http\Livewire\Exchange;

use App\Models\Watchlist;
use Livewire\Component;

class MarketsFav extends Component
{

    protected $listeners = ['refresh' => '$refresh'];
    public function render()
    {
        $favs = Watchlist::where('user_id',auth()->user()->id)->get();
        return view('livewire.exchange.markets-fav', compact('favs'));
    }
}
