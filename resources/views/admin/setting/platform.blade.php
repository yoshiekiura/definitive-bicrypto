@extends('layouts.app')
@section('content')
    <form action="{{ route('admin.platform.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <h4 class="card-header">System Settings</h4>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="sw">Service Worker</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="sw" id="sw"
                                    @if ($platform->system->sw) checked @endif>
                            </div>
                            <small class="text-warning">Enhance performance by caching all (js,css) files into the client
                                PC</small>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="frontend_status">{{ __('locale.Frontend') }}</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="frontend_status" id="frontend_status"
                                    @if ($platform->frontend->frontend_status) checked @endif>
                            </div>
                            <small class="text-warning">Disabled = Login page becomes the homepage</small>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="preloader">{{ __('locale.Frontend Preloader') }}</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="preloader" id="preloader"
                                    @if ($platform->frontend->preloader) checked @endif>
                            </div>
                            <small class="text-warning">Disabled = directly show frontend without waiting</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h4 class="card-header">Trading Settings</h4>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="binary_status">{{ __('locale.Binary Trading') }}</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="binary_status" id="binary_status"
                                    @if ($platform->trading->binary_status) checked @endif>
                            </div>
                            <small class="text-warning">Disabled = Crypto Exchange becomes the default dashboard</small>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="kyc_status">{{ __('locale.KYC') }}</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="kyc_status" id="kyc_status"
                                    @if ($platform->kyc->kyc_status) checked @endif>
                            </div>
                            <small class="text-warning">Disabled = Client directly start trading without any
                                verifications</small>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1"
                                    for="pair_prices">{{ __('locale.Trading Page Pair Prices') }}</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="pair_prices" id="pair_prices"
                                    @if ($platform->trading->pair_prices ?? '') checked @endif>
                            </div>
                            <small class="text-warning">Disabled = No pairs live price updates, faster loading</small>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="border-primary rounded p-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="practice">Practice Trading Only</label>
                                <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Inactive') }}" name="practice" id="practice"
                                    @if ($platform->trading->practice ?? '') checked @endif>
                            </div>
                            <small class="text-warning">Enabled = No deposits or withdrawals, Admin manually add balance to
                                clients, Trading become practice only</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-end">
                <div class="col">
                    <button type="submit" class="btn btn-primary">{{ __('locale.Update') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
