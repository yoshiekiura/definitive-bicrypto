<?php

namespace App\Http\Livewire;

use App\Models\CryptoCurrency;
use Livewire\Component;
use Livewire\WithFileUploads;

class CryptoAdd extends Component
{
    use WithFileUploads;
    public $name;
    public $symbol;
    public $status;
    public $image;

    protected $rules = [
        'name' => 'required|max:80|unique:crypto_currencies',
        'symbol' => 'required|unique:crypto_currencies|max:30',
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
        return view('livewire.crypto-add');
    }

    public function submit()
    {
        $this->validate();

    	$crypto = new CryptoCurrency();
    	$crypto->name = $this->name;
    	$crypto->symbol = strtoupper($this->symbol);
    	$crypto->status = $this->status ? 1 : 0;
        $this->image->storeAs('cryptoCurrency', $this->symbol.'.png');
        $filename = strtoupper($this->symbol).'.png';
        $crypto->image = $filename;

        // Read File
        $jsonString = file_get_contents(base_path('public/data/coinlist.json'));
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
        file_put_contents(base_path('public/data/coinlist.json'), stripslashes($newJsonString));

        $crypto->save();
	    session()->flash('message', 'Crypto Currency Created Successfully');
    }
}
