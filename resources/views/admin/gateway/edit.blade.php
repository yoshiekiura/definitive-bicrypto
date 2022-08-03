@extends('layouts.app')

@section('content')
<form action="{{ route('admin.payment.provider.update', $gateway->code) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="alias" value="{{ $gateway->alias }}">
    <input type="hidden" name="description" value="{{ $gateway->description }}">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <img class="img-thumbnail mb-1"
                                src="{{ getImage(imagePath()['gateway']['path'].'/'. $gateway->image,imagePath()['gateway']['size']) }}" />
                            <input class="form-control" name="image" type="file" id="image"
                                accept=".png, .jpg, .jpeg" />
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mt-2">
                                <h4 class="mb-2">{{ __('locale.Settings of')}} {{ __($gateway->name) }}</h4>
                                @foreach($parameters->where('global', true) as $key => $param)
                                <label>{{ __(@$param->title) }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="global[{{ $key }}]"
                                    value="{{ @$param->value }}" required />
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($gateway->code < 1000 && $gateway->extra)
                        <div class="mt-1">
                            <h4 class="mb-1">{{ __('locale.Configurations')}}</h4>
                            <div class="row mt-1">
                                @foreach($gateway->extra as $key => $param)
                                <div class="col col-lg-6">
                                    <label>{{ __(@$param->title) }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ route($param->value) }}"
                                            readonly />
                                        <div>
                                            <div class="input-group-text">
                                                <span class="copyInput" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('locale.Copy')}}"><i
                                                        class="bi bi-clipboard"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mt-2 py-2">
                        {{ __('locale.Update Setting')}}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="title">{{ __($gateway->name) }}</h3>
                        </div>
                        <div class="col">
                            <div class="input-group d-flex flex-wrap justify-content-start">
                                <select class="newCurrencyVal form-select">
                                    <option value="">{{ __('locale.Select currency')}}</option>
                                    @forelse($supportedCurrencies as $currency => $symbol)
                                    <option value="{{$currency}}" data-symbol="{{ $symbol }}">
                                        {{ __($currency) }} </option>
                                    @empty
                                    <option value="">{{ __('locale.No available currency support')}}
                                    </option>
                                    @endforelse

                                </select>
                                <button type="button" class="btn btn-primary newCurrencyBtn"
                                    data-crypto="{{ $gateway->crypto }}"
                                    data-name="{{ $gateway->name }}">{{ __('locale.Add new')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <p>{{ __($gateway->description) }}</p>
                    <!-- payment-method-item start -->
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @isset($gateway->currencies)
                    @foreach($gateway->currencies as $gateway_currency)
                    <input type="hidden" name="currency[{{ $currency_idx }}][symbol]"
                        value="{{ $gateway_currency->symbol }}">
                    <div class="row mt-2">
                        <div class="col-md-6 col-sm-12">
                            <img class="img-thumbnail mb-1 mt-1"
                                src="{{getImage(imagePath()['gateway']['path'].'/'.$gateway_currency->image,imagePath()['gateway']['size'])}}">
                            <input class="form-control" name="currency[{{ $currency_idx }}][image]" type="file"
                                id="mage{{ $currency_idx }}" accept=".png, .jpg, .jpeg" />
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4>{{ __($gateway->name) }} - {{__($gateway_currency->currency)}}</h4>
                            <input type="text" class="form-control" placeholder="{{ __('locale.Name for Provider')}}"
                                name="currency[{{ $currency_idx }}][name]" value="{{ $gateway_currency->name }}"
                                required />
                            <button type="button" class="btn btn-danger deleteBtn mt-1"
                                data-id="{{ $gateway_currency->id }}"
                                data-name="{{ $gateway_currency->currencyIdentifier() }}">
                                <i class="bi bi-trash me-2"></i>{{ __('locale.Remove')}}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card mt-2">
                        <h5 class="card-header bg-primary text-white">{{ __('locale.Payment Limits')}}</h5>
                        <div class="card-body">
                            <label class="w-100 mt-1">{{ __('locale.Minimum Amount')}} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-1">
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                <input type="text" class="form-control" name="currency[{{ $currency_idx }}][min_amount]"
                                    value="{{ ttz($gateway_currency->min_amount) }}" placeholder="0" required />
                            </div>
                            <label class="w-100">{{ __('locale.Maximum Amount')}} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                <input type="text" class="form-control" placeholder="0"
                                    name="currency[{{ $currency_idx }}][max_amount]"
                                    value="{{ ttz($gateway_currency->max_amount) }}" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card mt-2">
                        <h5 class="card-header bg-primary text-white">{{ __('locale.Fees')}}</h5>
                        <div class="card-body">
                            <label class="w-100 mt-1">{{ __('locale.Fixed Fee')}} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-1">
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                <input type="text" class="form-control" placeholder="0"
                                    name="currency[{{ $currency_idx }}][fixed_charge]"
                                    value="{{ ttz($gateway_currency->fixed_charge) }}" required />
                            </div>
                            <label class="w-100">{{ __('locale.Percentage Fee')}} <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">%</div>
                                <input type="text" class="form-control" placeholder="0"
                                    name="currency[{{ $currency_idx }}][percent_charge]"
                                    value="{{ ttz($gateway_currency->percent_charge) }}" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="card mt-2">
                        <h5 class="card-header bg-primary text-white">{{ __('locale.Conversion Rate')}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="my-1">
                                        <label class="w-100">{{ __('locale.Currency')}}</label>
                                        <input type="text" name="currency[{{ $currency_idx }}][currency]"
                                            class="form-control border-radius-5 "
                                            value="{{ $gateway_currency->currency }}" readonly />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="my-1">
                                        <label class="w-100">{{ __('locale.Symbol')}}</label>
                                        <input type="text" name="currency[{{ $currency_idx }}][symbol]"
                                            class="form-control border-radius-5 symbl"
                                            value="{{ $gateway_currency->symbol }}" data-crypto="{{ $gateway->crypto }}"
                                            required />
                                    </div>

                                </div>
                            </div>
                            <label class="w-100">{{ __('locale.Rate')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">1 {{ __($general->cur_text) }} = </div>
                                <input type="text" class="form-control" placeholder="0"
                                    name="currency[{{ $currency_idx }}][rate]" value="{{ $gateway_currency->rate +0 }}"
                                    required />
                                <div class="input-group-text"><span
                                        class="currency_symbol">{{ __($gateway_currency->baseSymbol()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @if($parameters->where('global', false)->count() != 0 )
                @php
                $gateway_parameter = json_decode($gateway_currency->gateway_parameter);
                @endphp
                <div class="col-lg-12">
                    <div class="card mt-2">
                        <h5 class="card-header bg-dark text-white">{{ __('locale.Configuration')}}</h5>
                        <div class="card-body">
                            <div class="row mt-1">
                                @foreach($parameters->where('global', false) as $key => $param)
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <label class="w-100">{{ __($param->title) }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            name="currency[{{ $currency_idx }}][param][{{ $key }}]"
                                            value="{{ $gateway_parameter->$key }}" placeholder="--" required />
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @php $currency_idx++ @endphp
            @endforeach
            @endisset
            <!-- payment-method-item end -->
            <!-- **new payment-method-item start -->

            <div class="child-item newMethodCurrency d-none">
                <input disabled type="hidden" name="currency[{{ $currency_idx }}][symbol]" class="currencySymbol">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <img class="img-thumbnail mb-1 mt-1"
                                    src="{{getImage(imagePath()['gateway']['path'],imagePath()['gateway']['size'])}}">
                                <input disabled type="file" accept=".png, .jpg, .jpeg" class="form-control"
                                    id="image{{ $currency_idx }}" name="currency[{{ $currency_idx }}][image]" />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="col">
                                    <h4 class="mb-1" id="payment_currency_name">{{ __('locale.Name')}}</h4>
                                    <input disabled type="text" class="form-control"
                                        placeholder="{{ __('locale.Name for Provider')}}"
                                        name="currency[{{ $currency_idx }}][name]" required />
                                </div>
                                <div class="col">
                                    <button type="button" class="mt-1 btn btn-danger newCurrencyRemove">
                                        <i class="bi bi-trash me-2"></i>{{ __('locale.Remove')}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card mt-2">
                            <h5 class="card-header bg-primary text-white">{{ __('locale.Range')}}</h5>
                            <div class="card-body">
                                <label class="w-100 mt-1">{{ __('locale.Minimum Amount')}} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                    <input disabled type="text" class="form-control"
                                        name="currency[{{ $currency_idx }}][min_amount]" placeholder="0" required />
                                </div>

                                <label class="w-100">{{ __('locale.Maximum Amount')}} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">

                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>


                                    <input disabled type="text" class="form-control" placeholder="0"
                                        name="currency[{{ $currency_idx }}][max_amount]" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card mt-2">
                            <h5 class="card-header bg-primary text-white">{{ __('locale.Charge')}}</h5>
                            <div class="card-body">
                                <label class="w-100 mt-1">{{ __('locale.Fixed Charge')}} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                    <input disabled type="text" class="form-control" placeholder="0"
                                        name="currency[{{ $currency_idx }}][fixed_charge]" required />
                                </div>
                                <label class="w-100">{{ __('locale.Percent Charge')}} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">%</div>
                                    <input disabled type="text" class="form-control" placeholder="0"
                                        name="currency[{{ $currency_idx }}][percent_charge]" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card mt-2">
                            <h5 class="card-header bg-primary text-white">{{ __('locale.Currency')}}</h5>
                            <div class="card-body">
                                <div class="row mt-1">
                                    <div class="col-md-6">
                                        <label class="w-100">{{ __('locale.Currency')}}</label>
                                        <div class="mb-1">
                                            <input disabled type="text"
                                                class="form-control currencyText border-radius-5"
                                                name="currency[{{ $currency_idx }}][currency]" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="w-100">{{ __('locale.Symbol')}}</label>
                                        <div class="mb-1">
                                            <input type="text" name="currency[{{ $currency_idx }}][symbol]"
                                                class="form-control border-radius-5 symbl"
                                                ata-crypto="{{ $gateway->crypto }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <label class="w-100">{{ __('locale.Rate')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <b>1 </b>&nbsp; {{ __($general->cur_text) }}&nbsp; =
                                    </div>
                                    <input disabled type="text" class="form-control" placeholder="0"
                                        name="currency[{{ $currency_idx }}][rate]" required />
                                    <div class="input-group-text"><span class="currency_symbol"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($parameters->where('global', false)->count() != 0 )
                    <div class="col-lg-12">
                        <div class="card  mt-2">
                            <h5 class="card-header bg-dark text-white">{{ __('locale.Configuration')}}</h5>
                            <div class="card-body">
                                <div class="row mt-2">
                                    @foreach($parameters->where('global', false) as $key => $param)
                                    <div class="col-md-6">
                                        <label class="w-100">{{ __($param->title) }} <span
                                                class="text-danger">*</span></label>
                                        <div class="mb-1">
                                            <input disabled type="text" class="form-control"
                                                name="currency[{{ $currency_idx }}][param][{{ $key }}]" placeholder="--"
                                                required />
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- **new payment-method-item end -->
        </div>
    </div>
</form>
<div id="deleteModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Provider Currency Remove Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payment.provider.remove', $gateway->code) }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to delete')}} <span class="fw-bold name"></span>
                        {{ __('locale.Provider currency?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ __('locale.Delete')}}</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.payment.provider.index') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i> {{ __('locale.Go Back')}}</a>
@endpush

@push('script')
    <script>
        $(function () {
            "use strict";

            $('.newCurrencyBtn').on('click', function () {
            var form = $('.newMethodCurrency');

            var getCurrencySelected = $('.newCurrencyVal').find(':selected').val();
            var currency = $(this).data('crypto') == 1 ? 'USD' : `${getCurrencySelected}`;

            if (!getCurrencySelected) return;
            form.find('input').removeAttr('disabled');
            var symbol = $('.newCurrencyVal').find(':selected').data('symbol');
            form.find('.currencyText').val(getCurrencySelected);
            form.find('.currency_symbol').text(currency);
            $('#payment_currency_name').text(`${$(this).data('name')} - ${getCurrencySelected}`);
            form.removeClass('d-none');
            $('html, body').animate({scrollTop: $('html, body').height()}, 'slow');

            $('.newCurrencyRemove').on('click', function () {
                form.find('input').val('');
                // form.addClass('d-none');
                form.remove();
            });

        });

        $('.deleteBtn').on('click', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.name').text($(this).data('name'));
            modal.modal('show');
        });

        $('.symbl').on('input', function () {
            var curText = $(this).data('crypto') == 1 ? 'USD' : $(this).val();
            $(this).parents('.payment-method-body').find('.currency_symbol').text(curText);
        });

        $('.copyInput').on('click', function (e) {
            var copybtn = $(this);
            var input = copybtn.parent().parent().siblings('input');
            if (input && input.select) {
                input.select();
                try {
                    document.execCommand('SelectAll')
                    document.execCommand('Copy', false, null);
                    input.blur();
                    copybtn.addClass('copied');
                    setTimeout(function () {
                        copybtn.removeClass('copied');
                    }, 1000);
                } catch (err) {
                    alert('Please press Ctrl/Cmd + C to copy');
                }
            }
        });

        });

    </script>
@endpush
