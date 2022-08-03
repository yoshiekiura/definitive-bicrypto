@extends('layouts.app')
<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: *");
?>
@section('content')
    <div id="market"></div>
@endsection

@section('page-script')
  <script async src="{{ asset(mix('js/market.js')) }}"></script>
@endsection
