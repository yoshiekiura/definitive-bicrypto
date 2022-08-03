@extends('layouts.app')

@section('content')
<form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data" id="editToken">
    @csrf
    <input type="hidden" name="is_active" id="is_active">
    <input type="hidden" name="network_id" id="network_id">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ 'General Settings' }}</h4>
            <div class="card-search"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label" for="name">{{ __('locale.Contract Network')}}</label>
                    <div class="dropdown mb-1">
                        <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="network" name="network">
                            {{ __('locale.Select Contract') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-mh" onmouseover="this.size=10;" onmouseout="this.size=1;">
                            @foreach ($networks as $network)
                            <li><a class="dropdown-item" onclick="$('#network').text($(this).text());
                                $('#editToken').find('input[name=network_id]').val($(this).data('network_id'));" data-network_id="{{ $network->id }}">{{ $network->chainName }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label" for="address">{{ __('locale.Contract Address')}}</label>
                    <div class="input-group mb-1">
                        <input type="name" class="form-control" id="address" name="address"
                            aria-describedby="address" value="{{ old('address') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label" for="symbol">{{ __('locale.Contract Symbol')}}</label>
                    <div class="input-group mb-1">
                        <input type="name" class="form-control" id="symbol" name="symbol"
                            aria-describedby="symbol" value="{{ old('symbol') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label" for="ABI">{{ __('locale.Contract ABI, (JSON format)')}}</label>
                        <textarea class="form-control" id="ABI" name="ABI" rows="3">{{ old('ABI') }}</textarea>
                      </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label" for="wallet_address">{{ __('locale.Wallet Address')}}</label>
                    <div class="input-group mb-1">
                        <input type="name" class="form-control" id="wallet_address" name="wallet_address"
                            aria-describedby="wallet_address" value="{{ old('wallet_address') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label" for="image">{{ __('locale.Icon URL')}}</label>
                    <div class="input-group mb-1">
                        <input type="name" class="form-control" id="image" name="image"
                            aria-describedby="image" value="{{ old('image') }}">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-label" for="status">{{ __('locale.Status')}}</div>
                    <div class="btn btn-outline-secondary btn-sm mb-1">
                        <div class="d-inline-block me-1 text-danger">{{ __('locale.Disabled')}}</div>
                        <div class="form-check form-switch d-inline-block">
                            <input type="checkbox" class="form-check-input" data-bs-toggle="toggle" name="status" id="status" style="cursor: pointer;">
                            <label for="site_state" class="form-check-label text-success">{{ __('locale.Enabled')}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end m-1">
            <button class="btn btn-success" type="submit"><i class="bi bi-pencil-square"></i> {{ __('locale.Add')}}
            </button>
        </div>
    </div>
</form>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.contracts.index') }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
