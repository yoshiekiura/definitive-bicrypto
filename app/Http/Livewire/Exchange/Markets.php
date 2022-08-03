<?php

namespace App\Http\Livewire\Exchange;

use App\Models\Pairs;
use Livewire\Component;

class Markets extends Component
{
    public $pair;
    public $markets;
    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $pair = $this->pair;
        $markets = $this->markets;
        return view('livewire.exchange.markets',compact('markets'));
    }
}
