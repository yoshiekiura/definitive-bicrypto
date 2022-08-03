@extends('layouts.app')
@section('page-style')

  <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css'))}}">
@endsection
@section('content')
<!-- Exchange Dashboard  -->
    <div class="row match-height" style="min-height: 40vh;">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-congratulation-medal" style="max-height:22vh;">
                <div class="card-body">
                    <h5>{{__('locale.Welcome')}} 🎉 {{auth()->user()->firstname}}</h5>
                    <a href="{{route('user.trade.now',["BTC","USDT"])}}" type="button" class="mt-3 btn btn-primary">{{__('locale.Start Trading')}}</a>
                    <img src="{{asset('images/illustration/badge.svg')}}" class="congratulation-medal"
                        alt="Medal Pic" />
                </div>
            </div>

            @if($wallets != null)
            <div class="card card-transaction">
                <div class="card-header">
                    <h4 class="card-title">{{__('locale.Wallets')}}</h4>
                </div>
                <div class="card-body mb-1" style="max-height:42vh;overflow-y:auto;">
                    @forelse($wallets as $wallet)
                    <div class="transaction-item">
                        <div class="d-flex">
                            <div class="avatar bg-light-primary rounded float-start">
                                <img class="avatar-content"
                                    src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wallet->symbol).'.png') }}"
                                    alt="">
                            </div>
                            <div class="transaction-percentage">
                                <h6 class="transaction-title">
                                    <span class="text-danger">{{ $wallet->symbol }}</span>
                                </h6>
                                <small>{{ttz($wallet->balance)}} {{$wallet->symbol}}</a></small>
                            </div>

                        </div>
                        <div class="fw-bolder">
                            <a href="{{route('user.wallet.info',['trading',$wallet->symbol,$wallet->address])}}"><button
                                    class="btn btn-sm btn-primary">{{__('locale.View')}}</button></a>
                        </div>
                    </div>
                    @empty
                        <div class="d-flex justify-content-between  align-items-center">
                            <span class="text-warning">{{ __('locale.Create your first wallet:')}}</span>
                            <form method="POST" action="{{ route('user.wallet.create') }}">
                                @csrf
                                <input type="hidden" id="symbol" name="symbol" value="USDT">
                                <input type="hidden" id="type" name="type" value="trading">
                                <button type="submit" class="btn btn-success btn-sm">{{__('locale.Create Wallet')}}</button></span>
                            </form>
                        </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <ul class="nav nav-tabs border" role="tablist">
                <li class="nav-item w-50">
                    <a class="nav-link active" id="market-tab" data-bs-toggle="tab" href="#market"
                        aria-controls="market" role="tab" aria-selected="true">Market Orders</a>
                </li>
                <li class="nav-item w-50">
                    <a class="nav-link" id="limit-tab" data-bs-toggle="tab" href="#limit" aria-controls="limit"
                        role="tab" aria-selected="false">Limit Orders</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="market" aria-labelledby="market-tab" role="tabpanel">
                    <div class="card" style="font-size: 11px;max-height: 74vh;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">{{ __('locale.Trade')}}</th>
                                        <th scope="col">{{ __('locale.Pricing')}}</th>
                                        <th scope="col">{{ __('locale.Order')}}</th>
                                        <th scope="col">{{ __('locale.Status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders['market'] as $order['market'])
                                    <tr>
                                        <td data-label="{{ __('locale.Trade')}}" class="text-uppercase">
                                            <div> {{ __('locale.Pair')}}: <span class="fw-bold text-info">{{ $order['market']->symbol }}</span></div>
                                            <div> {{ __('locale.ID')}}: <span class="fw-bold text-info">{{ $order['market']->order_id }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Pricing')}}">
                                            <div> {{ __('locale.Price')}}: <span class="fw-bold text-warning">{{getAmount($order['market']->price)}} {{ $order['market']->pair }}</span></div>
                                            <div> {{ __('locale.Amount')}}: <span class="fw-bold text-warning">{{getAmount($order['market']->amount)}} {{ getPair($order['market']->symbol)[0] }}</span></div>
                                            <div> {{ __('locale.Cost')}}: <span class="fw-bold text-warning">{{getAmount($order['market']->cost)}} {{ getPair($order['market']->symbol)[1] }}</span></div>
                                            <div> {{ __('locale.Fees')}}: <span class="fw-bold text-danger">{{ttz($order['market']->fee)}} {{ getPair($order['market']->symbol)[1] }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Order')}}">
                                            <div>{{ __('locale.Type')}}:
                                                    @if ($order['market']->side == 'buy')
                                                    <span class="fw-bold text-success">Buy
                                                @else
                                                    <span class="fw-bold text-danger">Sell
                                                @endif</span>
                                            </div>
                                            <div> {{ __('locale.Filled')}}: <span class="fw-bold text-info">{{ttz($order['market']->filled)}} {{ getPair($order['market']->symbol)[0] }}</span></div>
                                            <div> {{ __('locale.Remaining')}}: <span class="fw-bold text-danger">{{ttz($order['market']->remaining)}} {{ getPair($order['market']->symbol)[0] }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Status')}}">
                                            @if($order['market']->status == 'closed')
                                                <span class="badge bg-success">{{ __('locale.Filled')}}</span>
                                            @elseif($order['market']->status == 'open')
                                                <span class="badge bg-primary">{{ __('locale.Live')}}</span>
                                            @elseif($order['market']->status == 'canceled')
                                                <span class="badge bg-danger">{{ __('locale.Canceled')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="mt-0">{{paginateLinks($orders['market']) }}</div>
                </div>
                <div class="tab-pane" id="limit" aria-labelledby="limit-tab" role="tabpanel">
                    <div class="card" style="font-size: 11px;max-height: 74vh;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">{{ __('locale.Trade')}}</th>
                                        <th scope="col">{{ __('locale.Pricing')}}</th>
                                        <th scope="col">{{ __('locale.Order')}}</th>
                                        <th scope="col">{{ __('locale.Status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders['limit'] as $order['limit'])
                                    <tr>
                                        <td data-label="{{ __('locale.Trade')}}" class="text-uppercase">
                                            <div> {{ __('locale.Pair')}}: <span class="fw-bold text-info">{{ $order['limit']->symbol }}</span></div>
                                            <div> {{ __('locale.ID')}}: <span class="fw-bold text-info">{{ $order['limit']->order_id }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Pricing')}}">
                                            <div> {{ __('locale.Price')}}: <span class="fw-bold text-warning">{{getAmount($order['limit']->price)}} {{ $order['limit']->pair }}</span></div>
                                            <div> {{ __('locale.Amount')}}: <span class="fw-bold text-warning">{{getAmount($order['limit']->amount)}} {{ getPair($order['limit']->symbol)[0] }}</span></div>
                                            <div> {{ __('locale.Cost')}}: <span class="fw-bold text-warning">{{getAmount($order['limit']->cost)}} {{ getPair($order['limit']->symbol)[1] }}</span></div>
                                            <div> {{ __('locale.Fees')}}: <span class="fw-bold text-danger">{{ttz($order['limit']->fee)}} {{ getPair($order['limit']->symbol)[1] }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Order')}}">
                                            <div>{{ __('locale.Type')}}:
                                                    @if ($order['limit']->side == 'buy')
                                                    <span class="fw-bold text-success">Buy
                                                @else
                                                    <span class="fw-bold text-danger">Sell
                                                @endif</span>
                                            </div>
                                            <div> {{ __('locale.Filled')}}: <span class="fw-bold text-info">{{ttz($order['limit']->filled)}} {{ getPair($order['limit']->symbol)[0] }}</span></div>
                                            <div> {{ __('locale.Remaining')}}: <span class="fw-bold text-danger">{{ttz($order['limit']->remaining)}} {{ getPair($order['limit']->symbol)[0] }}</span></div>
                                        </td>
                                        <td data-label="{{ __('locale.Status')}}">
                                            @if($order['limit']->status == 'closed')
                                                <span class="badge bg-success">{{ __('locale.Filled')}}</span>
                                            @elseif($order['limit']->status == 'open')
                                                <span class="badge bg-primary">{{ __('locale.Live')}}</span>
                                                {{-- <form method="POST" action="{{ route('user.trade.cancel') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $order['limit']->order_id }}">
                                                    <input type="hidden" name="symbol" value="{{ $order['limit']->symbol }}">
                                                    <input type="hidden" name="pair" value="{{ $order['limit']->pair }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('locale.Cancel') }}</button></span>
                                                </form> --}}
                                                <a href="{{ route('user.trade.cancel',$order['limit']->order_id) }}"></a>
                                            @elseif($order['limit']->status == 'canceled')
                                                <span class="badge bg-danger">{{ __('locale.Canceled')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="mt-0">{{paginateLinks($orders['limit']) }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Referral Url Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush
