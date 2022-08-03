<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ICO;
use App\Models\IcoLogs;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ManageIcoController extends Controller
{
    public function index()
    {
        $page_title = 'ICO Manager';
        $icos = ICO::paginate(getPaginate(10));
        $empty_message = 'No Data Available';
        return view('admin.ico.index', compact('page_title', 'icos', 'empty_message'));
    }

    public function new()
    {
        $page_title = 'ICO Manager';
        return view('admin.ico.new', compact('page_title'));
    }
    public function edit($id)
    {
        $ico = ICO::findOrFail($id);
        $page_title = 'ICO Manager';
        return view('admin.ico.edit', compact('page_title', 'ico'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'symbol' => 'required|max:10',
            'liquidity' => 'required|numeric',
            'liquidity_supply' => 'required|numeric',
            'lockup' => 'required|numeric',
            'address' => 'required',
            'presale_address' => 'required',
            'decimals' => 'required|numeric',
            'network_symbol' => 'required|max:10',
            'total_supply' => 'required|numeric',
            'presale_supply' => 'required|numeric',
            'initial_cap' => 'required|numeric',
            'owner_max' => 'required|numeric',
            'owner_recieved' => 'required|numeric',
            'rate' => 'required|numeric',
            'contributors' => 'required|numeric',
            'desc' => 'required',
            'soft_price' => 'required|numeric',
            'soft_cap' => 'required|numeric',
            'soft_raised' => 'required|numeric',
            'hard_price' => 'required|numeric',
            'hard_cap' => 'required|numeric',
            'hard_raised' => 'required|numeric',
            'image' => 'mimes:jpeg,jpg,png,svg'
        ]);

        $ico = new ICO();
        $ico->name = $request->name;
        $ico->symbol = $request->symbol;
        $ico->type = $request->type;
        $ico->stage = $request->stage;
        $ico->status = $request->status;
        $ico->liquidity = $request->liquidity;
        $ico->liquidity_supply = $request->liquidity_supply;
        $ico->lockup = $request->lockup;
        $ico->address = $request->address;
        $ico->presale_address = $request->presale_address;
        $ico->decimals = $request->decimals;
        $ico->network_symbol = $request->network_symbol;
        $ico->total_supply = $request->total_supply;
        $ico->presale_supply = $request->presale_supply;
        $ico->initial_cap = $request->initial_cap;
        $ico->owner_max = $request->owner_max;
        $ico->owner_recieved = $request->owner_recieved;
        $ico->rate = $request->rate;
        $ico->contributors = $request->contributors;
        $ico->desc = $request->desc;
        $ico->soft_price = $request->soft_price;
        $ico->soft_cap = $request->soft_cap;
        $ico->soft_raised = $request->soft_raised;
        $ico->soft_start = $request->soft_start;
        $ico->soft_end = $request->soft_end;
        $ico->hard_price = $request->hard_price;
        $ico->hard_cap = $request->hard_cap;
        $ico->hard_raised = $request->hard_raised;
        $ico->hard_start = $request->hard_start;
        $ico->hard_end = $request->hard_end;

        $path = imagePath()['ico']['path'];
        $size = imagePath()['ico']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $ico->icon = $filename;
        }

        $ico->save();

        $notify[] = ['success', 'New Token Added Successfully'];
        return redirect()->route('admin.ico.index')->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'symbol' => 'required|max:10',
            'liquidity' => 'required|numeric',
            'liquidity_supply' => 'required|numeric',
            'lockup' => 'required|numeric',
            'address' => 'required',
            'presale_address' => 'required',
            'decimals' => 'required|numeric',
            'network_symbol' => 'required|max:10',
            'total_supply' => 'required|numeric',
            'presale_supply' => 'required|numeric',
            'initial_cap' => 'required|numeric',
            'owner_max' => 'required|numeric',
            'owner_recieved' => 'required|numeric',
            'rate' => 'required|numeric',
            'contributors' => 'required|numeric',
            'desc' => 'required',
            'soft_price' => 'required|numeric',
            'soft_cap' => 'required|numeric',
            'soft_raised' => 'required|numeric',
            'hard_price' => 'required|numeric',
            'hard_cap' => 'required|numeric',
            'hard_raised' => 'required|numeric',
            'image' => 'mimes:jpeg,jpg,png,svg'
        ]);

        $ico = ICO::findOrFail($request->id);
        $ico->name = $request->name;
        $ico->symbol = $request->symbol;
        $ico->type = $request->type;
        $ico->stage = $request->stage;
        $ico->status = $request->status;
        $ico->liquidity = $request->liquidity;
        $ico->liquidity_supply = $request->liquidity_supply;
        $ico->lockup = $request->lockup;
        $ico->address = $request->address;
        $ico->presale_address = $request->presale_address;
        $ico->decimals = $request->decimals;
        $ico->network_symbol = $request->network_symbol;
        $ico->total_supply = $request->total_supply;
        $ico->presale_supply = $request->presale_supply;
        $ico->initial_cap = $request->initial_cap;
        $ico->owner_max = $request->owner_max;
        $ico->owner_recieved = $request->owner_recieved;
        $ico->rate = $request->rate;
        $ico->contributors = $request->contributors;
        $ico->desc = $request->desc;
        $ico->soft_price = $request->soft_price;
        $ico->soft_cap = $request->soft_cap;
        $ico->soft_raised = $request->soft_raised;
        $ico->soft_start = $request->soft_start;
        $ico->soft_end = $request->soft_end;
        $ico->hard_price = $request->hard_price;
        $ico->hard_cap = $request->hard_cap;
        $ico->hard_raised = $request->hard_raised;
        $ico->hard_start = $request->hard_start;
        $ico->hard_end = $request->hard_end;

        $path = imagePath()['ico']['path'];
        $size = imagePath()['ico']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $ico->icon = $filename;
        }

        $ico->save();

        $notify[] = ['success', 'Token has been Updated'];
        return back()->withNotify($notify);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $ico = ICO::findOrFail($request->id);
        $icoLogs = IcoLogs::where('ico_id', $ico->id)->get();
        foreach ($icoLogs as $log) {
            $log->delete();
        }
        $ico->delete();

        $notify[] = ['success', 'Token has been removed with all its logs'];
        return back()->withNotify($notify);
    }

    public function log()
    {
        $page_title = "All ICO Sales List";
        $empty_message = "No Data Found";
        $user = User::get();
        $ico_logs = IcoLogs::latest()->paginate(getPaginate());
        $wallets = Wallet::get();
        return view('admin.ico.log', compact('page_title', 'empty_message', 'ico_logs', 'user', 'wallets'));
    }

    public function pay(Request $request)
    {
        $ico_log = IcoLogs::where('id', $request->id)->first();
        $ico_log->status = 1;
        $ico_log->recieved = $ico_log->amount;
        $ico_log->txHash = $request->txHash;
        $ico_log->txUrl = $request->txUrl;
        $ico_log->save();
        $notify[] = ['success', 'Payment Successful'];
        return back()->withNotify($notify);
    }

    public function pending()
    {
        $page_title = "Pending ICO Sales List";
        $empty_message = "No Data Found";
        $user = User::get();
        $ico_logs = IcoLogs::where('status', 0)->latest()->paginate(getPaginate());
        return view('admin.ico.log', compact('page_title', 'empty_message', 'ico_logs', 'user'));
    }

    public function completed()
    {
        $page_title = "Completed ICO Sales List";
        $empty_message = "No Data Found";
        $user = User::get();
        $ico_logs = IcoLogs::where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.ico.log', compact('page_title', 'empty_message', 'ico_logs', 'user'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $user = User::get();
        $empty_message = 'No search result was found.';
        $ico_logs =  IcoLogs::whereHas('user', function ($q) use ($search) {
            $q->where('username', $search);
        });
        if ($scope == 'pending') {
            $page_title .= 'Pending ICO Sales Search';
            $ico_logs = $ico_logs->where('status', 0);
        } elseif ($scope == 'completed') {
            $page_title .= 'Completed ICO Sales Search';
            $ico_logs = $ico_logs->where('status', 1);
        } elseif ($scope == 'list') {
            $page_title .= 'All ICO Sales Search';
        }
        $ico_logs = $ico_logs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.ico.log', compact('page_title', 'empty_message', 'ico_logs', 'search', 'user'));
    }
}
