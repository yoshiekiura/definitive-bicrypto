<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeLog;

class TradeLogController extends Controller
{

    public function index()
    {
    	$page_title = "Trade List";
    	$empty_message = "No Data Found";
    	$tradelogs = TradeLog::latest()->paginate(getPaginate());
    	return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }

    public function wining()
    {
        $page_title = "Wining Trade List";
        $empty_message = "No Data Found";
        $tradelogs = TradeLog::where('result', 1)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }

    public function losing()
    {
        $page_title = "Losing Trade List";
        $empty_message = "No Data Found";
        $tradelogs = TradeLog::where('result', 2)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }

    public function draw()
    {
        $page_title = "Draw Trade List";
        $empty_message = "No Data Found";
        $tradelogs = TradeLog::where('result', 3)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $tradelogs =  TradeLog::whereHas('user',function($q) use ($search){
            $q->where('username', $search);
        }); 
        if($scope == 'wining') {
            $page_title .= 'Wining Trade Search';
            $tradelogs = $tradelogs->where('result', 1);
        }
        elseif($scope == 'losing') {
             $page_title .= 'Losing Trade Search';
            $tradelogs = $tradelogs->where('result', 2);
        }
        elseif($scope == 'draw') {
            $page_title .= 'Draw Trade Search';
            $tradelogs = $tradelogs->where('result', 3);
        }
        elseif($scope == 'list') {
            $page_title .= 'All Trade History Search';
        }
        $tradelogs = $tradelogs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.trade_log.index', compact('page_title', 'empty_message', 'tradelogs', 'search'));
    }
}
