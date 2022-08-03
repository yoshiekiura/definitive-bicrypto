<?php

namespace App\Http\Controllers;

use App\Models\rssfeed;
use Illuminate\Http\Request;

class RssfeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'News';
        $urls = rssfeed::pluck('url')->toArray();

        $url = "https://cointelegraph.com/feed"; //https://blog.feedspot.com/cryptocurrency_rss_feeds/

        //foreach ($urls as $url) {
        $invalidurl = false;
        if (@simplexml_load_file($url)) {
            $feeds = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA)->channel;
            //dd($feeds);
        } else {
            $invalidurl = true;
            return view('errors.404');
        }
        //}

        return view('user.news.news', compact('page_title', 'feeds', 'invalidurl'));
    }

    public function fetch_news()
    {
        $page_title = 'News';
        $urls = rssfeed::pluck('url')->toArray();

        $url = "https://cointelegraph.com/feed"; //https://blog.feedspot.com/cryptocurrency_rss_feeds/

        //foreach ($urls as $url) {
        $invalidurl = false;
        if (@simplexml_load_file($url)) {
            $feeds = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
            //dd($feeds);
        } else {
            $invalidurl = true;
            return view('errors.404');
        }
        //}

        return response()->json([
            'feeds' => $feeds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rssfeed  $rssfeed
     * @return \Illuminate\Http\Response
     */
    public function show(rssfeed $rssfeed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rssfeed  $rssfeed
     * @return \Illuminate\Http\Response
     */
    public function edit(rssfeed $rssfeed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rssfeed  $rssfeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rssfeed $rssfeed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rssfeed  $rssfeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(rssfeed $rssfeed)
    {
        //
    }
}
