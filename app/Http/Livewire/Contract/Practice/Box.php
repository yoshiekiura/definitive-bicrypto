<?php

namespace App\Http\Livewire\Contract\Practice;

use App\Models\GeneralSetting;
use App\Models\PracticeLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Box extends Component
{
    public function render()
    {
        $user = Auth::user();
        $contracts = PracticeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
    	$gnl = GeneralSetting::first();
        return view('livewire.contract.practice.box', compact('contracts','gnl'));
    }
}
