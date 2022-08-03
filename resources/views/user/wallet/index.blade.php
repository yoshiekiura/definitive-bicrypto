@extends('layouts.app')
@section('content')
<div class="row row-cols-auto match-height" style="min-height: 40vh;">
    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12" style="max-height: 80vh;overflow-y:auto;">
        @if ($wallets != null)
        @foreach($wallets as $wallet)
        <div class="col-xs-6">
            <a href="{{ route('user.wallet.info',['funding',$wallet->symbol,$wallet->address]) }}">
                <div class="d-flex justify-content-between align-items-center
                @if(Request::is('**/wallets/'.$wallet->symbol)) bg-wallet-active @endif bg-wallet shadow-sm p-1 rounded mb-1">
                    <div class="col">
                        <img class="avatar-content" width="32px"
                            src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wallet->symbol).'.png') }}"
                            alt="{{ $wallet->symbol }}">
                    </div>
                    <div class="col">
                        <span class="fs-6 text-dark">{{$wallet->symbol}}</span>
                    </div>
                    <div class="col">
                        <span class="fs-6 text-dark">{{getAmount($wallet->balance)}}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @else
        <div class="col-xs-6">
            <div class="card align-items-center justify-content-center" style="min-width:214px;margin-bottom: 15px;">
                <i class="bi bi-plus-square-dotted display-4 mt-2"></i>
                <form method="POST" action="{{ route('user.wallet.create') }}">
                    @csrf
                    <input type="hidden" id="symbol" name="symbol" value="USDT">
                    <input type="hidden" id="type" name="type" value="funding">
                    <button type="submit" class="btn btn-success btn-sm my-1 stretched-link">{{ __('locale.Create Wallet') }}</button>
                </form>
            </div>
        </div>
        @endif
    </div>
    @if(Request::is('**/wallets/*'))
    <div class="col-xl-9 col-lg-8 col-md-7">
        <div class="card">
            <div class="card mb-1" style="background-color:#0000004d;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-3">
                            <img class="avatar-content"
                                src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wal->symbol).'.png') }}"
                                alt="{{ $wallet->symbol }}" />
                        </div>
                        <div class="col-lg-5 col-md-9">
                            <div class="d-flex justify-content-start align-items-center">
                                <a class="col" href="{{ route('user.deposit') }}"><button class="btn btn-success"><i class="bi bi-wallet2"></i> {{ __('locale.Deposit') }}</button></a>
                                <a class="col" href="{{ route('user.withdraw',$wal->symbol) }}"><button class="btn btn-danger"><i class="bi bi-cash-coin"></i> {{ __('locale.Withdraw') }}</button></a>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="input-group text-light">
                                <input class="form-control" type="text" id="balance"
                                    value="{{getAmount($wal->balance)}} @if($wal->symbol != 'USDT')&#8776; ({{getCoinRate($wal->symbol)}} USD) @endif" readonly>
                                <span class="input-group-text" for="balance">{{$wal->symbol}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-0" id="table-hover-row" style="overflow:auto;min-width:527px;">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Wallet Transactions') }}</h4>
                </div>
                <div class="table-responsive" style="min-height:280px;max-height:280px;overflow-y:auto;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Info') }}</th>
                                <th>{{ __('locale.Transaction') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wal_trx->where('user_id',auth()->user()->id) as $trx)
                            <tr>
                                <td>
                                    <div class="avatar bg-light-primary rounded float-start">
                                        <div class="avatar-content">
                                            @if($trx->type == 1)
                                            <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
                                            @elseif($trx->type == 2)
                                            <span class="text-danger fs-3"><i class="bi bi-cash"></i></span>
                                            @elseif($trx->type == 3)
                                            <span class="text-success fs-3"><i class="bi bi-send"></i></span>
                                            @elseif($trx->type == 4)
                                            <span class="text-warning fs-3"><i class="bi bi-envelope"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><span class="text-warning">{{ __('locale.Amount') }}:</span>
                                        {{ getAmount($trx->amount) }} {{ $wal->symbol }}</div>
                                    <div><span class="text-warning">{{ __('locale.Charge') }}:</span>
                                        {{ getAmount($trx->amount + $trx->charge) }} {{ $wal->symbol }}</div>
                                </td>
                                <td>
                                    @if ($trx->type == 1)
                                        <div class="avatar-group">
                                            <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
                                            <div class="my-0 me-2 text-success fs-3 ms-q" style=""><i class="bi bi-arrow-right"></i></div>
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0" title="{{ $trx->to }}">
                                                <img class="avatar-content" src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($symbol).'.png') }}"
                                                    alt="Avatar" />
                                            </div>
                                        </div>
                                    @elseif ($trx->type == 2)
                                        <div class="avatar-group">
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0"
                                                title="{{ $trx->address }}">
                                                <img class="avatar-content" src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wal->symbol).'.png') }}"
                                                    alt="Avatar" />
                                            </div>
                                            <div class="my-0 me-2 text-success fs-3 ms-1" style=""><i class="bi bi-arrow-right"></i></div>
                                            <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
                                        </div>
                                    @elseif ($trx->type == 3)
                                        <div class="avatar-group">
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0"
                                                title="{{ $trx->address }}">
                                                <img class="avatar-content" src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wal->symbol).'.png') }}"
                                                    alt="Avatar"/>
                                            </div>
                                            <div class="my-0 me-2 @if ($trx->status == 1) text-success @elseif($trx->status == 2) text-warning @else text-danger @endif fs-3 ms-1"><i class="bi bi-arrow-right"></i></div>
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0"
                                                title="{{ $trx->to }}">
                                                <span class="avatar-content fs-3"><i class="bi bi-person"></i></span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="avatar-group">
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0 "
                                                title="{{ $trx->address }}">
                                                <span class="avatar-content fs-3"><i class="bi bi-person"></i></span>
                                            </div>
                                            <div class="my-0 me-2 @if ($trx->status == 1) text-success @elseif($trx->status == 2) text-warning @else text-danger @endif fs-3 ms-1"><i class="bi bi-arrow-left"></i></div>
                                            <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                data-bs-placement="top" class="avatar pull-up my-0"
                                                title="{{ $trx->to }}">
                                                <img class="avatar-content" src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wal->symbol).'.png') }}"
                                                    alt="Avatar" />
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($trx->status == 1)
                                    <span class="badge rounded-pill badge-light-success me-1">{{ __('locale.Completed') }}</span>
                                    @elseif($trx->status == 2)
                                    <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                    @elseif($trx->status == 3)
                                    <span class="badge rounded-pill badge-light-danger me-1">{{ __('locale.Rejected') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-slide-in fade" id="send">
        <div class="modal-dialog sidebar-sm">
          <form class="add-new-record modal-content pt-0" action="{{route('user.wallet.send')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="from" name="from" value="{{ $wal->address }}">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
              <h5 class="modal-title" id="send1">{{ __('locale.Send Payment') }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
              <div class="mb-1">
                <label class="form-label" for="to">{{ __('locale.Reciever Wallet')}}</label>
                <input type="text" class="form-control to" id="to" maxlength="80" name="to" value="{{ old('to') }}" placeholder="{{ __('locale.Reciever Wallet')}}" required>
              </div>
              <div class="mb-1">
                  <label class="form-label" for="amount">{{ __('locale.Amount')}}</label>
                  <input type="text" class="form-control amount" id="amount" maxlength="30" name="amount" value="{{old('amount')}}" placeholder="{{ __('locale.Amount')}}" required>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="details">{{ __('locale.Details')}}</label>
                    <input type="text" class="form-control details" id="details" maxlength="30" name="details" value="{{old('details')}}" placeholder="{{ __('locale.Details')}}" required>
                  </div>
              <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Send')}}</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
            </div>
          </form>
        </div>
      </div>
      <div class="modal modal-slide-in fade" id="request">
        <div class="modal-dialog sidebar-sm">
          <form class="add-new-record modal-content pt-0" action="{{route('user.wallet.request')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="to" name="to" value="{{ $wal->address }}">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
              <h5 class="modal-title" id="request1">{{ __('locale.Request') }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
              <div class="mb-1">
                <label class="form-label" for="from">{{ __('locale.Request From Wallet')}}</label>
                <input type="text" class="form-control from" id="from" maxlength="80" name="from" value="{{ old('from') }}" placeholder="{{ __('locale.Wallet')}}" required>
              </div>
              <div class="mb-1">
                  <label class="form-label" for="amount">{{ __('locale.Amount')}}</label>
                  <input type="text" class="form-control amount" id="amount" maxlength="30" name="amount" value="{{old('amount')}}" placeholder="{{ __('locale.Amount')}}" required>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="details">{{ __('locale.Details')}}</label>
                    <input type="text" class="form-control details" id="details" maxlength="30" name="details" value="{{old('details')}}" placeholder="{{ __('locale.Details')}}" required>
                  </div>
              <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Request')}}</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
            </div>
          </form>
        </div>
      </div>
    @else
    <div class="col-9">
        <div class="card align-items-center justify-content-center">
            <i class="bi bi-wallet2 display-1"></i>
            <div class="display-3">{{ __('locale.Select a Wallet') }}</div>
        </div>
    </div>
    @endif
</div>
@endsection
@section('page-script')
    <script>

    </script>
@endsection
