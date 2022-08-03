@extends('layouts.app')
@section('content')

<div class="row justify-content-start">
    <div class="card col-lg-4 col-md-4">
        <div class="card-body">
            <div class="deposit-thumb">
                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="{{ __('locale.Payment Image')}}">
            </div>
            <div class="deposit-content justify-content-center">
                <ul class="text-center pb-3">
                    <li>
                        {{ __('locale.Final Amount')}}: <span class="text-success">{{getAmount($deposit->final_amo)}}
                            {{__($deposit->method_currency)}}</span>
                    </li>
                    <li>
                        {{ __('locale.To Get')}}: <span class="text-danger">{{getAmount($deposit->amount)}}
                            {{__($general->cur_text)}}</span>
                    </li>
                </ul>
                <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                    @csrf
                    <button type="button" class="btn btn-success" id="btn-confirm">{{ __('locale.Pay Now')}}</button>
                    <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}"
                        data-email="{{ $data->email }}" data-amount="{{$data->amount}}"
                        data-currency="{{$data->currency}}" data-ref="{{ $data->ref }}"
                        data-custom-button="btn-confirm">
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
