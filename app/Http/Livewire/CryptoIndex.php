<?php

namespace App\Http\Livewire;

use App\Models\CoinbaseMarkets;
use App\Models\CryptoCurrency;
use App\Models\CryptoPair;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CryptoIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $pair;
    public $whatpair;
    protected $listeners = ['whatpair' => 'render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $user = Auth::user();
        if ($this->provider == 'coinbasepro'){
        $markets = CryptoCurrency::where('status', 1)->where('currency', 'like', '%'.$this->search.'%')->orWhere('pair', 'like', '%'.$this->search.'%')->paginate(12);
        $pairss = CryptoPair::where('status', 1)->get();
        $pair = $this->whatpair;
        }
        return view('livewire.crypto-index',compact('cryptos','pair','pairss','markets'));
    }
}
