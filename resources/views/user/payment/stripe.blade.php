@extends('layouts.app')
@section('content')

<div class="row justify-content-start">
    <div class="card col-lg-4 col-md-4">
            <div class="card-header">{{ __('locale.Stripe Payment')}}</div>
            <div class="card-body card-body-deposit">
                <div class="card-wrapper"></div>
                <br><br>
                <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$data->track}}" name="track">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">{{ __('locale.CARD NAME')}}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ __('locale.Card Name')}}" autocomplete="off" autofocus />
                                <span class="input-group-text bg-info "><i
                                        class="bi bi-person-badge"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cardNumber">{{ __('locale.CARD NUMBER')}}</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" name="cardNumber"
                                    placeholder="{{ __('locale.Valid Card Number')}}" autocomplete="off" required
                                    autofocus />
                                <span class="input-group-text bg-info"><i
                                        class="bi bi-credit-card"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label for="cardExpiry">{{ __('locale.EXPIRATION DATE')}}</label>
                            <input type="tel" class="form-control input-sz"
                                name="cardExpiry" placeholder="{{ __('locale.MM / YYYY')}}" autocomplete="off"
                                required />
                        </div>
                        <div class="col-md-6 ">
                            <label for="cardCVC">{{ __('locale.CVC CODE')}}</label>
                            <input type="tel" class="form-control input-sz"
                                name="cardCVC" placeholder="{{ __('locale.CVC')}}" autocomplete="off" required />
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary text--white" type="submit"> {{ __('locale.Pay Now')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
