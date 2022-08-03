@extends('layouts.app')
@section('content')
    <div class="dashboard-section ">
        <div>
            <div class="pb-3">
                <div class="row g-4">
                    @foreach ($withdrawMethod as $data)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="card deposit-card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __($data->name) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="deposit__thumb">
                                        <img style="height: 100px;width: 100%;"
                                            src="{{ getImage(imagePath()['withdraw']['method']['path'] . '/' . $data->image, imagePath()['withdraw']['method']['size']) }}"
                                            alt="{{ __($data->name) }}">
                                    </div>
                                    <ul class="list-group text-center list-group">
                                        <li class="list-group-item">@lang('Limit')
                                            : {{ getAmount($data->min_limit) }}
                                            - {{ getAmount($data->max_limit) }} {{ __($general->cur_text) }}</li>

                                        <li class="list-group-item"> {{ __('locale.Charge') }}
                                            - {{ getAmount($data->fixed_charge) }} {{ __($general->cur_text) }}
                                            + {{ getAmount($data->percent_charge) }}%
                                        </li>
                                        <li class="list-group-item"> {{ __('locale.Rate') }}
                                            <span class="text-info">1 {{ __($general->cur_text) }} =
                                                {{ getCurrency()->rate }} {{ getCurrency()->symbol }}</span>
                                        </li>
                                        <li class="list-group-item">@lang('Processing Time')
                                            - {{ $data->delay }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="javascript:void(0)" data-id="{{ $data->id }}"
                                        data-resource="{{ $data }}"
                                        data-min_amount="{{ getAmount($data->min_limit) }}"
                                        data-max_amount="{{ getAmount($data->max_limit) }}"
                                        data-fix_charge="{{ getAmount($data->fixed_charge) }}"
                                        data-percent_charge="{{ getAmount($data->percent_charge) }}"
                                        data-base_symbol="{{ __($general->cur_text) }}"
                                        class="btn mt-2 btn-success deposit" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        @lang('Withdraw Now')</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade custom-modal" id="exampleModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title method-name"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.withdraw.money') }}" method="POST">
                    @csrf
                    <input type="hidden" id="symbol" name="symbol" value="{{ $symbol }}">
                    <input type="hidden" name="currency" class="edit-currency form-control" value="">
                    <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">

                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>

                        <div class="col">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input class="form-control" type="number" id="amount"
                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                    placeholder="0.00" required="" value="{{ old('amount') }}">
                                <span class="input-group-text">{{ __($general->cur_text) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm text-white btn-danger"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit"
                            class="btn btn-primary btn-sm text-white btn-success">{{ __('locale.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.deposit').on('click', function() {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit =
                    `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{ __($general->cur_text) }}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge =
                    `{{ __('locale.Charge') }}: ${fixCharge} {{ __($general->cur_text) }} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });


        });
    </script>
@endpush
