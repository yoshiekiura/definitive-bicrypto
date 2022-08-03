<?php

namespace App\Http\Livewire\Binary\Practice;

use Livewire\Component;

class Balance extends Component
{
    public $symbol;
    public $currency;
    protected $listeners = ['refreshBalance' => '$refresh'];

    public function render()
    {
        return view('livewire.binary.practice.balance');
    }
}
