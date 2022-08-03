<?php

namespace App\Http\Livewire;

use App\Models\CryptoPair;
use Livewire\Component;
use Livewire\WithFileUploads;

class PairAdd extends Component
{
    use WithFileUploads;
    public $name;
    public $symbol;
    public $status;
    public $image;

    protected $rules = [
        'name' => 'required|max:80|unique:crypto_pairs',
        'symbol' => 'required|unique:crypto_pairs|max:30',
        'image' => 'required|image|mimes:jpeg,jpg,png,svg'
    ];
    protected $messages = [
        'name.required' => 'The Name cannot be empty.',
        'name.max' => 'The Name cannot exceed 80 character.',
        'name.unique' => 'The Name is used, Try another.',
        'symbol.required' => 'The Symbol cannot be empty.',
        'symbol.unique' => 'The Symbol is used, Try another.',
        'image.required' => 'The Image cannot be empty.',
        'image.image' => 'The Image format is not valid.',
    ];

    public function render()
    {
        return view('livewire.pair-add');
    }

    public function submit()
    {
        $this->validate();

    	$crypto = new CryptoPair();
    	$crypto->name = $this->name;
    	$crypto->symbol = strtoupper($this->symbol);
    	$crypto->status = $this->status ? 1 : 0;
        $this->image->storeAs('cryptoCurrency', $this->symbol.'.png');
        $filename = strtoupper($this->symbol).'.png';
        $crypto->image = $filename;

        // Read File
        $jsonString = file_get_contents(resource_path('/data/coinpair.json'));
        $data = json_decode($jsonString, true);
        // Update Key
        $newID = count($data['data']) + 2;
        $data['data'][] = [
                'responsive_id' => "",
                'id' => $newID,
                'name' => $this->name,
                'image' => $filename,
                'symbol' => strtoupper($this->symbol),
                'status' => $this->status ? 1 : 0];
        // Write File
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('/data/coinpair.json'), stripslashes($newJsonString));

        $crypto->save();
	    session()->flash('message', 'Crypto Pair Created Successfully');
    }
}
