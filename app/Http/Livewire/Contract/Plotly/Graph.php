<?php

namespace App\Http\Livewire\Contract\Plotly;

use Livewire\Component;

class Graph extends Component
{
    protected $listeners = ['plotlyRefresh' => '$refresh'];
    public function render()
    {
        return view('livewire.contract.plotly.graph');
    }
}
