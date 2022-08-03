<?php

namespace App\Http\Livewire\Exchange;

use App\Models\Pairs;
use Livewire\Component;

class MarketsAll extends Component
{
    public function render()
    {
        $pairs = Pairs::where('provider',$this->provider)->where('status',1)->pluck('symbol');
        $jsonString = file_get_contents(public_path('data/markets/markets.json'));
        $datas = json_decode($jsonString, true);
        // Update Key
        foreach($pairs as $pair) {
            foreach($datas[$this->provider] as $data) {
                if($data['pair'] == $pair){
                    $markets[$pair][] = $data;
                }
            }
        }
        return view('livewire.exchange.markets-all');
    }
}
