<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PracticeLog;

class PracticeTradeController extends Controller
{
    public function index()
    {
    	$page_title = "Practice Trade List";
    	$empty_message = "No Data Found";
    	$practiceLogs = PracticeLog::latest()->paginate(getPaginate());
    	return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs'));
    }

    public function wining()
    {
        $page_title = "Practice Wining Trade List";
        $empty_message = "No Data Found";
        $practiceLogs = PracticeLog::where('result', 1)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs'));
    }

    public function losing()
    {
        $page_title = "Practice Losing Trade List";
        $empty_message = "No Data Found";
        $practiceLogs = PracticeLog::where('result', 2)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs'));
    }

    public function draw()
    {
        $page_title = "Practice Draw Trade List";
        $empty_message = "No Data Found";
        $practiceLogs = PracticeLog::where('result', 3)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $practiceLogs =  PracticeLog::whereHas('user',function($q) use ($search){
            $q->where('username', $search);
        }); 
        if($scope == 'wining') {
            $page_title .= 'Practice Wining Trade Search';
            $practiceLogs = $practiceLogs->where('result', 1);
        }
        elseif($scope == 'losing') {
            $page_title .= 'Practice Losing Trade Search';
            $practiceLogs = $practiceLogs->where('result', 2);
        }
        elseif($scope == 'draw') {
            $page_title .= 'Practice Draw Trade Search';
            $practiceLogs = $practiceLogs->where('result', 3);
        }
        elseif($scope == 'list') {
            $page_title .= 'All Practice Trade History Search';
        }
        $practiceLogs = $practiceLogs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.practice.index', compact('page_title', 'empty_message', 'practiceLogs', 'search'));
    }
}
