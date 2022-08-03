<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contracts;
use App\Models\Networks;
use Illuminate\Http\Request;

class ManageContractsController extends Controller
{
    public function index()
    {
        $page_title = 'Contracts Manager';
        $contracts = Contracts::paginate(getPaginate(10));
        return view('admin.ico.contract.index', compact('page_title','contracts'));
    }
    public function new()
    {
        $page_title = 'New contract';
        $networks = Networks::where('status',1)->get();
        return view('admin.ico.contract.new', compact('page_title','networks'));
    }
    public function edit($id)
    {
        $contract = Contracts::findOrFail($id);
        $page_title = 'Contracts Editor';
        $networks = Networks::where('status',1)->get();
        $contract_network = Networks::where('id',$contract->network_id)->first();
        return view('admin.ico.contract.edit', compact('page_title','contract','networks','contract_network'));
    }
    public function store(Request $request)
    {
        $request->validate([
    		'symbol' => 'required|max:10',
    		'address' => 'required|max:80',
    		'wallet_address' => 'required|max:80',
    		'ABI' => 'required',
    	]);

        $contract = new Contracts();
        $contract->symbol = $request->symbol;
        $contract->address = $request->address;
        $contract->wallet_address = $request->wallet_address;
        $contract->ABI = $request->ABI;
        $contract->network_id = $request->network_id;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $contract->status = $request->status;

        $contract->image = $request->image;
        $contract->save();

        $notify[] = ['success', 'New Contract Added Successfully'];
        return redirect()->route('admin.contracts.index')->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
    		'symbol' => 'required|max:10',
    		'address' => 'required|max:80',
    		'wallet_address' => 'required|max:80',
    		'ABI' => 'required'
    	]);

        $contract = Contracts::findOrFail($request->id);
        $contract->symbol = $request->symbol;
        $contract->address = $request->address;
        $contract->wallet_address = $request->wallet_address;
        $contract->ABI = $request->ABI;
        $contract->network_id = $request->network_id;

        /*$path = imagePath()['contract']['path'];
        $size = imagePath()['contract']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $contract->image = $filename;
        }*/
        $contract->image = $request->image;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $contract->status = $request->status;
        $contract->save();

        $notify[] = ['success', 'Contract has been Updated'];
        return redirect()->route('admin.contracts.index')->withNotify($notify);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $contract = Contracts::findOrFail($request->id);
        $contract->delete();

        $notify[] = ['success', 'Contract has been removed'];
        return back()->withNotify($notify);
    }
}
