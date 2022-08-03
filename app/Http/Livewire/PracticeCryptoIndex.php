<?php

namespace App\Http\Livewire;

use App\Models\CryptoCurrency;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PracticeCryptoIndex extends Component
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
        $cryptos = CryptoCurrency::where('status', 1)->where('symbol', 'like', '%'.$this->search.'%')->paginate(12);
        $watched = Watchlist::where('user_id', $user->id)->pluck('symbol')->toArray();
        $pair = $this->whatpair;
        return view('livewire.practice-crypto-index',compact('cryptos','watched','pair'));
    }
}
