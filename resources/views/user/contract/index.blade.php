@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-4">
        @foreach($markets as $market)
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center">
                        <img class="avatar-content" width="32px"
                            src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->pair).'.png') }}"
                            alt="{{ $market->pair }}">
                        <span class="ms-1 fw-bold">{{ $market->symbol }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8">

        <div class="row">
            @foreach($markets as $market)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('user.trade.now',[$market->currency,$market->pair]) }}">
                            <div class="d-flex justify-content-start align-items-center">
                                <img class="avatar-content" width="32px"
                                src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->currency).'.png') }}"
                                alt="{{ $market->currency }}">
                                <i class="bi bi-chevron-right"></i>
                                <img class="avatar-content" width="32px"
                                    src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->pair).'.png') }}"
                                    alt="{{ $market->pair }}">
                                <span class="ms-1 fw-bold">{{ $market->symbol }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<div class="modal fade text-start" id="addWatchlist" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Add Crypto Currency')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.watchlist.store')}}" method="POST">
                <input type="hidden" id="inputfav" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure want to watchlist this coin')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-success">{{ __('locale.Add')}}</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<div id="deleteWatchlist" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Delete Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.watchlist.delete')}}" method="POST">
                @csrf
                <input type="hidden" id="bk" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure want to remove this coin from watchlist')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-success">{{ __('locale.Delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
