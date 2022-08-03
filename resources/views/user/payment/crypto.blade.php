@extends('layouts.app')
@section('content')

<div class="row justify-content-start">
    <div class="card col-lg-4 col-md-4">
        <div class="card-body">
            <div class="card card-deposit text-center">
                <div class="deposit-card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('locale.Payment Preview')}}</h3>
                    </div>
                </div>
                <div class="card-body card-body-deposit text-center">
                    <h4 class="my-2  text-info"> {{ __('locale.PLEASE SEND EXACTLY')}} <span class="text-success">
                            {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                    <h5 class="mb-2">{{ __('locale.TO')}} <span class="text-success"> {{ $data->sendto }}</span></h5>
                    <img class="crypto-img" src="{{$data->img}}" alt="{{ __('locale.image')}}">
                    <h4 class="text-danger bold my-4">{{ __('locale.SCAN TO SEND')}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
