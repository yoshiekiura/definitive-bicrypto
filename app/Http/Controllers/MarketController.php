<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MarketController extends Controller
{
    //
    public function index()
    {
        $page_title="";
        return view('user.market',compact('page_title'));
    }
}
