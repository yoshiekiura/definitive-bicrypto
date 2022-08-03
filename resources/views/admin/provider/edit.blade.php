@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ 'Editing ' . $provider->title . ' provider' }}</h4>
            <div class="card-search"></div>
        </div>
        <form action="{{ route('admin.provider.update') }}" method="POST" enctype="multipart/form-data"
            id="providerUpdate">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $provider->id }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label for="title">{{ __('locale.Title') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="title" name="title" aria-label="provider Title"
                                aria-describedby="title" value="{{ $provider->title }}" disabled>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label for="api">{{ __('locale.API') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="api" name="api" aria-label="provider api"
                                aria-describedby="api" value="{{ $provider->api }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label for="secret">{{ __('locale.Secret') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="secret" name="secret" aria-label="provider secret"
                                aria-describedby="secret" value="{{ $provider->secret }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label for="password">Passphrase</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="password" name="password"
                                aria-label="provider password" aria-describedby="password"
                                value="{{ $provider->password }}">
                        </div>
                        <small>You passphrase must be your API key trading password, not your funding password and not your
                            login password. </small>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" data-bs-toggle="toggle" name="status" id="status"
                            @if ($provider->status == 1) checked @endif>
                        <label class="form-check-label" for="is_new">{{ __('locale.is Active') }}?</label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-success" type="submit"><i class="bi bi-pencil-square"></i> {{ __('locale.Edit') }}
                </button>
            </div>
        </form>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.provider.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('locale.Back') }}</a>
@endpush
