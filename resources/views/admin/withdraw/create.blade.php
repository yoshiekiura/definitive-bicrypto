@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.withdraw.method.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h6 class="card-title">@lang('New Method Form')</h6>
                        <div class="payment-method-item">
                            <div class="payment-method-header row">
                                <div class="col-lg-3">
                                    <img class="img-thumbnail mb-1"
                                        src="{{getImage('/',imagePath()['withdraw']['method']['size'])}}" />
                                    <input type="file" name="image" class="form-control" id="image"
                                        accept=".png, .jpg, .jpeg" />
                                </div>

                            <div class="col-lg-9">
                                <div class="row mt-1">
                                    <div class="col-md-6">
                                        <div class="justify-content-between">
                                            <label class="h6">{{ __('locale.Method Name')}} <span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="h6">{{ __('locale.Currency')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="currency" class="form-control rounded"
                                            value="{{ old('currency') }}" />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="h6">{{ __('locale.Rate')}} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text">1 {{ __($general->cur_text) }} =</div>
                                            <input type="text" class="form-control" placeholder="0" name="rate"
                                                value="{{ old('rate') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="h6">@lang('Processing Time') <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="delay" class="form-control rounded"
                                            value="{{ old('delay') }}" />
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="payment-method-body mt-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card border-primary">
                                            <h5 class="card-header bg-light">{{ __('locale.Range')}}</h5>
                                            <div class="card-body">
                                                    <label class="mt-1 h6">{{ __('locale.Minimum Amount')}} <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                        <input type="text" class="form-control" name="min_limit" placeholder="0" value="{{ old('min_limit') }}"/>
                                                    </div>
                                                    <label class="mt-1 h6">{{ __('locale.Maximum Amount')}} <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                        <input type="text" class="form-control" placeholder="0" name="max_limit" value="{{ old('max_limit') }}"/>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card border-primary">
                                            <h5 class="card-header bg-light">{{ __('locale.Charge')}}</h5>
                                            <div class="card-body">
                                                    <label class="mt-1 h6">{{ __('locale.Fixed Charge')}} <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                        <input type="text" class="form-control" placeholder="0" name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                                    </div>
                                                    <label class="mt-1 h6">{{ __('locale.Percent Charge')}} <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">%</div>
                                                        <input type="text" class="form-control" placeholder="0" name="percent_charge" value="{{ old('percent_charge') }}">
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border-dark my-2">

                                            <h5 class="card-header bg-light">@lang('Withdraw Instruction') </h5>
                                            <div class="card-body">
                                                <div class="col mt-1">
                                                    <textarea rows="5" class="form-control rounded" name="instruction">{{ old('instruction') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border-dark">
                                            <h5 class="card-header bg-dark text-light">{{ __('locale.User data')}}
                                                <button type="button" class="btn btn-sm btn-outline-light float-end addUserData">
                                                    <i class="bi bi-plus"></i>{{ __('locale.Add new')}}
                                                </button>
                                            </h5>

                                            <div class="card-body">
                                                <div class="row addedField">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mt-2">@lang('Save Method')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.withdraw.method.index') }}" class="btn btn-primary">
        <i class="bi bi-chevron-left"></i> {{ __('locale.Go Back')}}
    </a>
@endpush
@section('vendor-script')


@endsection
@push('script')
    <script>
        $(function () {
            "use strict";
        $('input[name=currency]').on('input', function () {
            $('.currency_symbol').text($(this).val());
        });

        $('.addUserData').on('click', function () {
            var html = `
                <div class="col-md-12 user-data">
                    <div class="col">
                        <div class="mt-1 row input-group mb-md-0 mb-4">
                            <div class="col-md-4">
                                <input name="field_name[]" class="form-control" type="text" value="" required placeholder="@lang('Field Name')">
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <select name="type[]" class="form-control">
                                    <option value="text" > {{ __('locale.Input Text')}} </option>
                                    <option value="textarea" > {{ __('locale.Textarea')}} </option>
                                    <option value="file"> {{ __('locale.File upload')}} </option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <select name="validation[]"
                                        class="form-control">
                                    <option value="required"> {{ __('locale.Required')}} </option>
                                    <option value="nullable">  {{ __('locale.Optional')}} </option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2 text-end">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger btn-lg removeBtn h6" type="button">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;

            $('.addedField').append(html);
        });


        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.user-data').remove();
        });

        @if(old('currency'))
        $('input[name=currency]').trigger('input');
        @endif
        });

    </script>
@endpush
