@extends('layouts.app')
@section('content')

<div class="row justify-content-start">
    <div class="card col-lg-4 col-md-4">
        <div class="card-body">
            <div class="deposit-thumb">
                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="{{ __('locale.Payment Image')}}">
            </div>
            <div class="deposit-content justify-content-center">
                <ul class="text-center">
                    <li>
                        {{ __('locale.Final Amount')}}: <span class="text-success">{{getAmount($deposit->final_amo)}}
                            {{__($deposit->method_currency)}}</span>
                    </li>
                    <li>
                        {{ __('locale.To Get')}}: <span class="text-danger">{{getAmount($deposit->amount)}}
                            {{__($general->cur_text)}}</span>
                    </li>
                </ul>
                <button type="button" class="btn btn-success" id="btn-confirm"
                    onClick="payWithRave()">{{ __('locale.Pay Now')}}</button>
                <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                <script>
                    var btn = document.querySelector("#btn-confirm");
                    btn.setAttribute("type", "button");
                    const API_publicKey = "{{$data->API_publicKey}}";

                    function payWithRave() {
                        var x = getpaidSetup({
                            PBFPubKey: API_publicKey,
                            customer_email: "{{$data->customer_email}}",
                            amount: "{{$data->amount }}",
                            customer_phone: "{{$data->customer_phone}}",
                            currency: "{{$data->currency}}",
                            txref: "{{$data->txref}}",
                            onclose: function () {},
                            callback: function (response) {
                                var txref = response.tx.txRef;
                                var status = response.tx.status;
                                var chargeResponse = response.tx.chargeResponseCode;
                                if (chargeResponse == "00" || chargeResponse == "0") {
                                    window.location = '{{ url('
                                    ipn / flutterwave ') }}/' + txref + '/' + status;
                                } else {
                                    window.location = '{{ url('
                                    ipn / flutterwave ') }}/' + txref + '/' + status;
                                }

                            }
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
