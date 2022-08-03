<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Networks;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index()
    {
        $page_title = 'Networks Manager';
        $networks = Networks::paginate(getPaginate(10));
        return view('admin.ico.network.index', compact('page_title','networks'));
    }
    public function new()
    {
        $page_title = 'New Network';
        return view('admin.ico.network.new', compact('page_title'));
    }
    public function edit($id)
    {
        $network = Networks::findOrFail($id);
        $page_title = 'Networks Editor';
        return view('admin.ico.network.edit', compact('page_title','network'));
    }
    public function store(Request $request)
    {
        $request->validate([
    		'name' => 'required|max:80',
    		'symbol' => 'required|max:10',
    		'chainId' => 'required|max:80',
    		'chainName' => 'required|max:80',
    		'decimals' => 'required|numeric',
    		'rpcUrls' => 'required',
    		'blockExplorerUrls' => 'required',
    	]);

        $network = new Networks();
        $network->name = $request->name;
        $network->symbol = $request->symbol;
        $network->chainId = $request->chainId;
        $network->chainName = $request->chainName;
        $network->decimals = $request->decimals;
        $network->rpcUrls = $request->rpcUrls;
        $network->blockExplorerUrls = $request->blockExplorerUrls;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $network->status = $request->status;

        $network->save();

        $notify[] = ['success', 'New Chain Added Successfully'];
        return redirect()->route('admin.networks.index')->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
    		'name' => 'required|max:80',
    		'symbol' => 'required|max:10',
    		'chainId' => 'required|max:80',
    		'chainName' => 'required|max:80',
    		'decimals' => 'required|numeric',
    		'rpcUrls' => 'required',
    		'blockExplorerUrls' => 'required',
    	]);

        $network = Networks::findOrFail($request->id);
        $network->name = $request->name;
        $network->symbol = $request->symbol;
        $network->chainId = $request->chainId;
        $network->chainName = $request->chainName;
        $network->decimals = $request->decimals;
        $network->rpcUrls = $request->rpcUrls;
        $network->blockExplorerUrls = $request->blockExplorerUrls;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $network->status = $request->status;
        $network->save();

        $notify[] = ['success', 'Chain has been Updated'];
        return redirect()->route('admin.networks.index')->withNotify($notify);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $network = Networks::findOrFail($request->id);
        $network->delete();

        $notify[] = ['success', 'Chain has been removed'];
        return back()->withNotify($notify);
    }
}
