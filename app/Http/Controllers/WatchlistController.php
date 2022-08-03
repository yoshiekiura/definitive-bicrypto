<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favs()
    {
        return response()->json([
            'favs' => Watchlist::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (Watchlist::where('user_id', $user->id)->where('currency', $request->currency)->where('pair', $request->pair)->exists()) {
            return response()->json(
                [
                    'success' => true,
                    'type' => 'warning',
                    'message' => 'Pair already in Watchlist'
                ]
            );
        } else {
            $watchlists = new Watchlist();
            $watchlists->user_id = $user->id;
            $watchlists->currency = $request->currency;
            $watchlists->pair = $request->pair;
            $watchlists->type = 1;
            $watchlists->save();
            return response()->json(
                [
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Pair added to watchlist Successfully'
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function show(Watchlist $watchlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Watchlist $watchlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Watchlist $watchlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $request->validate(['id' => 'required|exists:watchlists,id']);
        $watchlist = Watchlist::where('id', $request->id)->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Pair Removed From Watchlist Successfully'
            ]
        );
    }
}
