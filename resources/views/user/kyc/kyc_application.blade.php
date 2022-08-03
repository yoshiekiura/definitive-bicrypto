@extends('layouts.app')
@section('title', __('Begin ID-Verification'))
@php
$has_sidebar = false;
$page_title ="Begin ID-Verification"
@endphp
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css'))}}">
@endsection
@section('content')
<div class="page-header page-header-kyc">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7 text-center">
            <h2 class="page-title">{{__('Begin your ID-Verification')}}</h2>
            <p class="large">{{__('Verify your identity to start using your trade wallet.')}}</p>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        <div class="kyc-form-steps card mx-lg-4">
            <form class="validate-modern" action="{{ route('user.kyc.submit') }}" method="POST" id="kyc_submit" enctype="multipart/form-data">
                @csrf
                @include('layouts.kyc-form')
            </form>
        </div>
    </div>
</div>

@endsection
@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset('js/core/jquery.bundle.js') }}"></script>
  <script src="{{ asset(mix('js/kyc/kyc.js')) }}"></script>
@endsection
