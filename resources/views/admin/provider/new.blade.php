@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{ __('locale.New Bot')}}</h4><div class="card-search"></div>
    </div>
    <form action="{{ route('admin.mlm.store') }}" method="POST" enctype="multipart/form-data" id="newBot">
        @csrf
        <div class="card-body">
            <input type="hidden" name="result_missed" id="result_missed">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="title">{{ __('locale.Title')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="title" name="title" aria-label="Rank Title" aria-describedby="title" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="rank">{{ __('locale.Rank')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="rank" name="rank" aria-label="Rank" aria-describedby="rank" value="{{ old('rank') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="bv">{{ __('locale.Minimum BV To Enable Withdraw')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="bv" name="bv" aria-label="Rank BV Minimum For Withdraw" aria-describedby="bv" value="{{ old('bv') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="margin">{{ __('locale.Withdraw Margin')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="margin" name="margin" aria-label="Rank Withdraw Margin" aria-describedby="margin" value="{{ old('margin') }}">
                        <span class="input-group-text" for="margin">%</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="deposit_commission">{{ __('locale.Referral Deposit Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="deposit_commission" name="deposit_commission" aria-label="Deposit Commission" aria-describedby="deposit_commission" value="{{ old('deposit_commission') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="ref_commission">{{ __('locale.Referral First Deposit Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="ref_commission" name="ref_commission" aria-label="ref Commission" aria-describedby="ref_commission" value="{{ old('ref_commission') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="active_ref_commission">{{ __('locale.Active Referral First Deposit Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="active_ref_commission" name="active_ref_commission" aria-label="active_ref Commission" aria-describedby="active_ref_commission" value="{{ old('active_ref_commission') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="trade_commission">{{ __('locale.Referral Trade Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="trade_commission" name="trade_commission" aria-label="trade Commission" aria-describedby="trade_commission" value="{{ old('trade_commission') }}">
                    </div>
                </div>
                @if ($bot->status == 1)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="bot_commission">{{ __('locale.Referral Bot Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="bot_commission" name="bot_commission" aria-label="bot Commission" aria-describedby="bot_commission" value="{{ old('bot_commission') }}">
                    </div>
                </div>
                @endif
                @if ($ico->status == 1)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="ico_commission">{{ __('locale.Referral Token ICO Purchase Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="ico_commission" name="ico_commission" aria-label="ico Commission" aria-describedby="ico_commission" value="{{ old('ico_commission') }}">
                    </div>
                </div>
                @endif
                @if ($forex->status == 1)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="forex_commission">{{ __('locale.Forex Deposit Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="forex_commission" name="forex_commission" aria-label="ico Commission" aria-describedby="forex_commission" value="{{ old('forex_commission') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="forex_investment_commission">{{ __('locale.Forex Investment Commission')}}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="forex_investment_commission" name="forex_investment_commission" aria-label="ico Commission" aria-describedby="forex_investment_commission" value="{{ old('forex_investment_commission') }}">
                    </div>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-start align-items-top">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle" name="status" id="status">
                    <label class="form-check-label" for="is_new">{{ __('locale.is Active')}}?</label>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success" type="submit">{{ __('locale.Submit')}}
            </button>
        </div>
    </form>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.mlm.index') }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
