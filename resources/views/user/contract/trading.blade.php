@extends('layouts.app')

@section('page-style')
    <style>
    </style>
@endsection

@section('content')
    <div id="trade"></div>
@endsection

@section('page-script')
    <script type="text/javascript" src="{{ mix('/vendors/js/ccxt.js') }}"></script>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script>
        const config = { enableRateLimit: true, newUpdates: true , proxy: '{{$cors}}','options': { 'tradesLimit': 10,}}
        window.exchange = new ccxt.{{ $provider }} (config);
    </script>
    <script async src="{{ asset(mix('js/trade/index.js')) }}"></script>
@endsection
