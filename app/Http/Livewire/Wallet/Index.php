<?php

namespace App\Http\Livewire\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $user = Auth::user();
        if(Wallet::where('user_id', $user->id)->sum('balance') > 0){
            $wallets = Wallet::where('user_id', $user->id)->where('balance','!=','0')->where('symbol', 'like', '%'.$this->search.'%')->paginate(8);

        } else {
            $wallets = Wallet::where('user_id', $user->id)->where('symbol', 'like', '%'.$this->search.'%')->paginate(8);
        }
        return view('livewire.wallet.index', compact('user','wallets'));
    }
}
