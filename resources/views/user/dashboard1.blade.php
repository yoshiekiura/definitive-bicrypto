@extends('layouts.app')

@section('page-style')
    <style>
    </style>
@endsection

@section('content')
    <div id="trade"></div>
@endsection

@section('page-script')
  <script async src="{{ asset(mix('js/trade/index.js')) }}"></script>
  <script>
      window.markets = {{ $markets }};
  </script>
@endsection
