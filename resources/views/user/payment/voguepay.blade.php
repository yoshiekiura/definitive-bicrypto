@extends('layouts.app')
@section('content')

<div class="dashboard-section ">
    <div>
        <div class="pb-3">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="deposit-preview bg--body align-items-center">
                        <div class="deposit-thumb">
                            <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="{{ __('locale.Payment Image')}}">
                        </div>
                        <div class="deposit-content justify-content-center ">
                            <ul class="text-center pb-3">
                                <li>
                                    {{ __('locale.Final Amount')}}: <span class="text--success">{{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</span>
                                </li>
                                <li>
                                    {{ __('locale.To Get')}}: <span class="text--danger">{{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                        <button type="button" class="btn btn-success" id="btn-confirm">{{ __('locale.Pay Now')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('script-lib')
    <script src="//voguepay.com/js/voguepay.js"></script>
@endpush
@push('script')
    <script>
        "use strict";
        closedFunction = function() {
        }
        successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        $(document).ready(function () {
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush


