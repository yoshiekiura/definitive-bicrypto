@extends('layouts.app')
@section('content')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <form action="" method="POST" enctype="multipart/form-data" id="generalSettings">
                @csrf
                <input type="hidden" name="update_server" id="update_server">
                <div class="card">
                    <h4 class="card-header">Settings</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6"> {{ __('locale.Site Title') }} </label>
                                    <input class="form-control form-control-lg" type="text" name="sitename"
                                        value="{{ $general->sitename }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Cors Link') }} </label>
                                    <input class="form-control form-control-lg" type="text" name="cors"
                                        value="{{ $general->cors }}">
                                    <small>Follow cors guide on our documentation</small>
                                </div>
                            </div>
                            @if ($general->staging != 1 && $wal_connect->status == 1)
                                <div class="col-md-3">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('locale.Moralis Server URL') }}
                                        </label>
                                        <input class="form-control form-control-lg" type="text" name="moralis_server_url"
                                            value="{{ $general->moralis_server_url }}">
                                        <a href="https://admin.moralis.io/login" target="__blank"><small>Moralis</small></a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('locale.Moralis App ID') }} </label>
                                        <input class="form-control form-control-lg" type="text" name="moralis_app_id"
                                            value="{{ $general->moralis_app_id }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h4 class="card-header">Rates Settings</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Currency') }}</label>
                                    <input class="form-control form-control-lg" type="text" name="cur_text"
                                        value="{{ $general->cur_text }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Currency Symbol') }} </label>
                                    <input class="form-control form-control-lg" type="text" name="cur_sym"
                                        value="{{ $general->cur_sym }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-control-label h6">{{ __('locale.Practice Balance') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="practice_balance"
                                        placeholder="{{ __('locale.Enter Amount') }}"
                                        value="{{ getAmount($general->practice_balance) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $general->practice_wallet }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Practice Wallet') }} </label>
                                    <input class="form-control form-control-lg" type="text" name="practice_wallet"
                                        value="{{ $general->practice_wallet }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('locale.Trade Profit') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="profit"
                                        placeholder="{{ __('locale.Enter Amount') }}"
                                        value="{{ getAmount($general->profit) }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('locale.Exchange Fee') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="exchange_fee"
                                        placeholder="{{ __('locale.Enter Percentage') }}"
                                        value="{{ getAmount($general->exchange_fee) }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('locale.Transaction Fee') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="trx_fee"
                                        placeholder="{{ __('locale.Enter Percentage') }}"
                                        value="{{ getAmount($general->trx_fee) }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('locale.Referral Bonus') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="referral_bonus"
                                        placeholder="{{ __('locale.Enter Amount') }}"
                                        value="{{ getAmount($general->referral_bonus) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('locale.Thirdparty Withdraw Fees') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                        name="provider_withdraw_fee" placeholder="{{ __('locale.Enter Amount') }}"
                                        value="{{ getAmount($general->provider_withdraw_fee) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h4 class="card-header">Trade Limits Settings</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Minimum Amount') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="min_amount"
                                        step="0.00000001" value="{{ $limits->min_amount ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Maximum Amount') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="max_amount"
                                        value="{{ $limits->max_amount ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Minimum Seconds') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="min_time_sec"
                                        value="{{ $limits->min_time_sec ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Maximum Seconds') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="max_time_sec"
                                        value="{{ $limits->max_time_sec ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Minimum Minutes') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="min_time_min"
                                        value="{{ $limits->min_time_min ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Maximum Minutes') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="max_time_min"
                                        value="{{ $limits->max_time_min ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Minimum Hours') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="min_time_hour"
                                        value="{{ $limits->min_time_hour ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('locale.Trades Maximum Hours') }}
                                    </label>
                                    <input class="form-control form-control-lg" type="number" name="max_time_hour"
                                        value="{{ $limits->max_time_hour ?? 0 }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h4 class="card-header">Extra Settings</h4>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-start">

                            <div class="border-primary rounded p-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1"
                                        for="referal_status">{{ __('locale.Referral Status') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('locale.Active') }}" data-off="{{ __('locale.Inactive') }}"
                                        name="referal_status" @if ($general->referal_status) checked @endif>
                                </div>
                            </div>

                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1"
                                        for="registration">{{ __('locale.User Registration') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('locale.Enable') }}" data-off="{{ __('locale.Disabled') }}"
                                        name="registration" @if ($general->registration) checked @endif>
                                </div>
                            </div>
                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="force_ssl">{{ __('locale.Force SSL') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('locale.Enable') }}" data-off="{{ __('locale.Disabled') }}"
                                        name="force_ssl" @if ($general->force_ssl) checked @endif>
                                </div>
                            </div>
                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="APP_DEBUG">{{ __('locale.App Debug') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger"
                                        data-on="{{ __('locale.Enable') }}" data-off="{{ __('locale.Disabled') }}"
                                        name="APP_DEBUG" @if (getenv('APP_DEBUG') == 'true') checked @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __('locale.Update') }}</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
