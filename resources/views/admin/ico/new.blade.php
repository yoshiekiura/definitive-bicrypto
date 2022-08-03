@extends('layouts.app')
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection
@section('content')
    <form action="{{ route('admin.ico.store') }}" method="POST" enctype="multipart/form-data" id="editToken">
        @csrf

        <input type="hidden" name="id" id="id" value="{{ old('id') }}">
        <input type="hidden" name="status" id="status">
        <input type="hidden" name="stage" id="stage">
        <input type="hidden" name="type" id="type">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ 'General Settings' }}</h4>
                <div class="card-search"></div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="name">{{ __('locale.Name') }}</label>
                        <div class="input-group mb-1">
                            <input type="name" class="form-control" id="name" name="name" aria-describedby="name"
                                value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="symbol">{{ __('locale.Symbol') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="symbol" name="symbol" aria-describedby="symbol"
                                value="{{ old('symbol') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="name">{{ __('locale.Crowdsale Type') }}</label>
                        <div class="dropdown mb-1">
                            <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="selected_type" name="selected_type">
                                Select Type
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_type').text($(this).text());$('#editToken').find('input[name=type]').val('1');">{{ __('locale.Soft') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_type').text($(this).text());$('#editToken').find('input[name=type]').val('2');">{{ __('locale.Soft/Hard') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="name">{{ __('locale.Crowdsale Stage') }}</label>
                        <div class="dropdown mb-1">
                            <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="selected_stage" name="selected_stage">
                                Select Stage
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_stage').text($(this).text());$('#editToken').find('input[name=stage]').val('1');">{{ __('locale.Soft Cap Started') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_stage').text($(this).text());$('#editToken').find('input[name=stage]').val('2');">{{ __('locale.Soft Cap Ended') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_stage').text($(this).text());$('#editToken').find('input[name=stage]').val('3');">{{ __('locale.Hard Cap Started') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="name">{{ __('locale.Status') }}</label>
                        <div class="dropdown mb-1">
                            <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="selected_status" name="selected_status">
                                Select Status
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_status').text($(this).text());$('#editToken').find('input[name=status]').val('0');">{{ __('locale.Upcoming') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_status').text($(this).text());$('#editToken').find('input[name=status]').val('1');">{{ __('locale.Sale Live') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_status').text($(this).text());$('#editToken').find('input[name=status]').val('2');">{{ __('locale.Sale Ended') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        onclick="$('#selected_status').text($(this).text());$('#editToken').find('input[name=status]').val('3');">{{ __('locale.Canceled') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="liquidity">{{ __('locale.Liquidity') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="liquidity" name="liquidity"
                                aria-describedby="liquidity" value="{{ old('liquidity') }}">
                            <span class="input-group-text" for="liquidity">%</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="liquidity_supply">{{ __('locale.Liquidity Supply') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="liquidity_supply" name="liquidity_supply"
                                aria-describedby="liquidity_supply" value="{{ old('liquidity_supply') }}">
                            <span class="input-group-text" for="hard_price">Token Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="lockup">{{ __('locale.Lockup Duration') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="lockup" name="lockup" aria-describedby="lockup"
                                value="{{ old('lockup') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="address">{{ __('locale.Token Address') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="address" name="address" aria-describedby="address"
                                value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"
                            for="presale_address">{{ __('locale.Token Presale Address') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="presale_address" name="presale_address"
                                aria-describedby="presale_address" value="{{ old('presale_address') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="decimals">{{ __('locale.Token Decimals') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="decimals" name="decimals"
                                aria-describedby="decimals" value="{{ old('decimals') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="network_symbol">{{ __('locale.Network Symbol') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="network_symbol" name="network_symbol"
                                aria-describedby="network_symbol" value="{{ old('network_symbol') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="total_supply">{{ __('locale.Total Supply') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="total_supply" name="total_supply"
                                aria-describedby="total_supply" value="{{ old('total_supply') }}">
                            <span class="input-group-text" for="hard_price">Token Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="presale_supply">{{ __('locale.Presale Supply') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="presale_supply" name="presale_supply"
                                aria-describedby="presale_supply" value="{{ old('presale_supply') }}">
                            <span class="input-group-text" for="hard_price">Token Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="initial_cap">{{ __('locale.Initial Cap') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="initial_cap" name="initial_cap"
                                aria-describedby="initial_cap" value="{{ old('initial_cap') }}">
                            <span class="input-group-text" for="hard_price">Network Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="owner_max">{{ __('locale.Owner Max') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="owner_max" name="owner_max"
                                aria-describedby="owner_max" value="{{ old('owner_max') }}">
                            <span class="input-group-text" for="hard_price">Network Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="owner_recieved">{{ __('locale.Owner Recieved') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="owner_recieved" name="owner_recieved"
                                aria-describedby="owner_recieved" value="{{ old('owner_recieved') }}">
                            <span class="input-group-text" for="hard_price">Network Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="rate">{{ __('locale.Rate') }}</label>
                        <div class="input-group mb-1">
                            <span class="input-group-text" for="hard_price">1
                                Network Symbol = </span>
                            <input type="text" class="form-control" id="rate" name="rate" aria-describedby="rate"
                                value="{{ old('rate') }}">
                            <span class="input-group-text" for="hard_price">Token Symbol</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label" for="contributors">{{ __('locale.Contributors') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="contributors" name="contributors"
                                aria-describedby="contributors" value="{{ old('contributors') }}">
                        </div>
                    </div>
                    <div class="col-12 mb-1">
                        <label class="form-label" for="desc">{{ __('locale.Description') }}</label>
                        <textarea type="text" class="form-control" id="desc" name="desc" aria-describedby="desc" rows="10">
{{ old('desc') }}
</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top mb-1">
                    <div>
                        <input class="form-control" name="image" type="file" id="image" accept=".png, .jpg, .jpeg" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Soft Cap Settings</h4>
                        <div class="card-search"></div>
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="soft_cap">{{ __('locale.Soft Cap Quantity') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" id="soft_cap" name="soft_cap"
                                    aria-describedby="soft_cap" value="{{ old('soft_cap') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="soft_price">{{ __('locale.Soft Cap Price') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" id="soft_price" name="soft_price"
                                    aria-describedby="soft_price" step="0.0000001" value="{{ old('soft_price') }}">
                                <span class="input-group-text" for="hard_price">Network Symbol</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label"
                                for="soft_raised">{{ __('locale.Soft Cap Initial Raised') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" id="soft_raised" name="soft_raised"
                                    aria-label="ico APR" aria-describedby="soft_raised" value="{{ old('soft_raised') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label"
                                for="soft_start">{{ __('locale.Soft Cap Start Date') }}</label>
                            <input type="text" id="soft_start" name="soft_start" class="form-control flatpickr-date-time"
                                value="{{ old('soft_start') }}" placeholder="YYYY-MM-DD HH:MM" />
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="soft_end">{{ __('locale.Soft Cap End Date') }}</label>
                            <input type="text" id="soft_end" name="soft_end" class="form-control flatpickr-date-time"
                                value="{{ old('soft_end') }}" placeholder="YYYY-MM-DD HH:MM" />
                        </div>
                        {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="soft_bonus">{{ __('locale.Soft Cap Bonus') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="soft_bonus" name="soft_bonus"
                                aria-label="ico APR" aria-describedby="soft_bonus" value="{{ old('soft_bonus }}">
                            <span class="input-group-text" for="max_profit">%</span>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ 'Hard Cap Stage Settings' }}</h4>
                        <div class="card-search"></div>
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="hard_cap">{{ __('locale.Hard Cap Quantity') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" id="hard_cap" name="hard_cap"
                                    aria-describedby="hard_cap" value="{{ old('hard_cap') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="hard_price">{{ __('locale.Hard Cap Price') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" step="0.0000001" id="hard_price"
                                    name="hard_price" aria-describedby="hard_price" value="{{ old('hard_price') }}">
                                <span class="input-group-text" for="hard_price">Network Symbol</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label"
                                for="hard_raised">{{ __('locale.Hard Cap Initial Raised') }}</label>
                            <div class="input-group mb-1">
                                <input type="number" class="form-control" id="hard_raised" name="hard_raised"
                                    aria-label="ico APR" aria-describedby="hard_raised" value="{{ old('hard_raised') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label"
                                for="hard_start">{{ __('locale.Hard Cap Start Date') }}</label>
                            <input type="text" id="hard_start" name="hard_start" class="form-control flatpickr-date-time"
                                value="{{ old('hard_start') }}" placeholder="YYYY-MM-DD HH:MM" />
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="hard_end">{{ __('locale.Hard Cap End Date') }}</label>
                            <input type="text" id="hard_end" name="hard_end" class="form-control flatpickr-date-time"
                                value="{{ old('hard_end') }}" placeholder="YYYY-MM-DD HH:MM" />
                        </div>
                        {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label" for="hard_bonus">{{ __('locale.Hard Cap Bonus') }}</label>
                    <div class="input-group mb-1">
                        <input type="number" class="form-control" id="hard_bonus" name="hard_bonus" aria-label="ico APR"
                            aria-describedby="hard_bonus" value="{{ old('hard_bonus }}">
                        <span class="input-group-text" for="max_profit">%</span>
                    </div>
                </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="text-end m-1">
                <button class="btn btn-success" type="submit"><i class="bi bi-pencil-square"></i>
                    {{ __('locale.Edit') }}
                </button>
            </div>
        </div>
    </form>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.ico.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('locale.Back') }}</a>
@endpush

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection
