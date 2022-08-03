<?php

namespace App\Http\Livewire\ThirdParty;

use Livewire\Component;
use Livewire\WithPagination;

class Fees extends Component
{
    use WithPagination;
    public $fees;

    public function mount($fees)
    {
        $this->fees = $fees;
    }

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $feess = json_decode(json_encode($this->fees), FALSE);
        return view('livewire.third-party.fees', compact('feess'));
    }
}
