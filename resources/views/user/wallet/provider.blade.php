@extends('layouts.app')
@section('content')
    <div class="row match-height" style="min-height: 40vh;">
        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12" style="max-height: 80vh;overflow-y:auto;">
            <ul class="nav nav-tabs border" role="tablist">
                <li class="nav-item w-50">
                    <a class="nav-link @if (!Request::is('**/funding/**')) active @endif" id="trading-tab" data-bs-toggle="tab"
                        href="#trading" aria-controls="trading" role="tab"
                        aria-selected="@if (!Request::is('**/funding/**')) true @else false @endif">Trading Wallet</a>
                </li>
                <li class="nav-item w-50">
                    <a class="nav-link @if (Request::is('**/funding/**')) active @endif" id="funding-tab" data-bs-toggle="tab"
                        href="#funding" aria-controls="funding" role="tab"
                        aria-selected="@if (Request::is('**/funding/**')) true @else false @endif">Funding Wallet</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane @if (!Request::is('**/funding/**')) active @endif" id="trading"
                    aria-labelledby="trading-tab" role="tabpanel">
                    @if ($trading_wallets != null)
                        @foreach ($trading_wallets as $wallet)
                            @if ($wallet->address != null)
                                <div class="col-xs-6">
                                    <a
                                        href="{{ route('user.wallet.info', ['trading', $wallet->symbol, $wallet->address]) }}">
                                        <div
                                            class="d-flex justify-content-between align-items-center
                                @if (Request::is('**/wallets/trading/' . $wallet->symbol)) bg-wallet-active @endif bg-wallet shadow-sm p-1 rounded mb-1">
                                            <div class="col">
                                                <img class="avatar-content" width="32px"
                                                    src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wallet->symbol) . '.png') }}"
                                                    alt="{{ $wallet->symbol }}">
                                            </div>
                                            <div class="col">
                                                <span class="fs-6 text-dark">{{ $wallet->symbol }}</span>
                                            </div>
                                            <div class="col">
                                                <span class="fs-6 text-dark">{{ ttz($wallet->balance) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div class="col-xs-6">
                        <div class="card align-items-center justify-content-center"
                            style="min-width:214px;margin-bottom: 15px;">
                            <i class="bi bi-plus-square-dotted display-4 mt-2"></i>
                            <button data-bs-toggle="modal" data-bs-target="#newWallet"
                                class="btn btn-success btn-sm my-1 stretched-link"
                                onclick="$('#newWallet').find('input[name=type]').val($(this).data('type'));"
                                data-type="trading">{{ __('locale.Create Wallet') }}</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane @if (Request::is('**/funding/**')) active @endif" id="funding"
                    aria-labelledby="funding-tab" role="tabpanel">
                    @if ($funding_wallets != null)
                        @foreach ($funding_wallets as $wallet)
                            @if ($wallet->address != null)
                                <div class="col-xs-6">
                                    <a
                                        href="{{ route('user.wallet.info', ['funding', $wallet->symbol, $wallet->address]) }}">
                                        <div
                                            class="d-flex justify-content-between align-items-center
                                @if (Request::is('**/wallets/funding/' . $wallet->symbol)) bg-wallet-active @endif bg-wallet shadow-sm p-1 rounded mb-1">
                                            <div class="col">
                                                <img class="avatar-content" width="32px"
                                                    src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wallet->symbol) . '.png') }}"
                                                    alt="{{ $wallet->symbol }}">
                                            </div>
                                            <div class="col">
                                                <span class="fs-6 text-dark">{{ $wallet->symbol }}</span>
                                            </div>
                                            <div class="col">
                                                <span class="fs-6 text-dark">{{ ttz($wallet->balance) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div class="col-xs-6">
                        <div class="card align-items-center justify-content-center"
                            style="min-width:214px;margin-bottom: 15px;">
                            <i class="bi bi-plus-square-dotted display-4 mt-2"></i>
                            <button data-bs-toggle="modal" data-bs-target="#newWallet"
                                class="btn btn-success btn-sm my-1 stretched-link"
                                onclick="$('#newWallet').find('input[name=type]').val($(this).data('type'));"
                                data-type="funding">{{ __('locale.Create Wallet') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="newWallet" tabindex="-1" aria-labelledby="newWallet" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5 class="modal-title">{{ __('locale.Create New Wallet') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="add-new-record modal-content pt-0" autocomplete="off" method="POST"
                        action="{{ route('user.wallet.create') }}">
                        @csrf
                        <div class="modal-body pb-3 px-sm-3">
                            <input type="hidden" id="symbol" name="symbol">
                            <input type="hidden" id="type" name="type">
                            <div class="d-flex justify-content-between">
                                <div class="dropdown">
                                    <button class="btn btn-outline-warning dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" id="walletSelected"
                                        name="walletSelected">
                                        {{ __('locale.Select Wallet') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end p-1" id="myDropdown">
                                        <input type="text" class="form-control" placeholder="Search.." id="myInput"
                                            onkeyup="filterFunction()" autocomplete="off">
                                        <div style="max-height:300px;overflow-y:auto;">
                                            @foreach ($currencies as $currency)
                                                <li><a class="dropdown-item"
                                                        onclick="$('#walletSelected').text($(this).text());$('#newWallet').find('input[name=symbol]').val($(this).data('symbol'));"
                                                        data-symbol="{{ $currency->symbol }}">
                                                        <img class="avatar-content me-1" width="32px"
                                                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($currency->symbol) . '.png') }}"
                                                            alt="{{ $currency->symbol }}" loading="lazy">
                                                        {{ $currency->symbol }}</a></li>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                                <button type="submit" class="btn btn-success">{{ __('locale.Create Wallet') }}</button>
                            </div>
                            <script>
                                function filterFunction() {
                                    var input, filter, ul, li, a, i;
                                    input = document.getElementById("myInput");
                                    filter = input.value.toUpperCase();
                                    div = document.getElementById("myDropdown");
                                    a = div.getElementsByTagName("a");
                                    for (i = 0; i < a.length; i++) {
                                        txtValue = a[i].textContent || a[i].innerText;
                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                            a[i].style.display = "";
                                        } else {
                                            a[i].style.display = "none";
                                        }
                                    }
                                }
                            </script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (Request::is('**/funding/*', '**/trading/*'))
            <div class="col-xl-9 col-lg-8 col-md-7">
                <div class="card">
                    <div class="card mb-1" style="background-color:#0000004d;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-lg-2 col-md-3">
                                    <img class="avatar-content"
                                        src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wal->symbol) . '.png') }}"
                                        alt="{{ $wallet->symbol }}" />
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-none">
                                    {{ $wal->symbol }}
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="input-group text-light">
                                        <input class="form-control" type="text" id="balance"
                                            value="{{ getAmount($wal->balance) }} @if ($wal->symbol != 'USDT')  @endif"
                                            readonly>
                                        <span class="input-group-text" for="balance">{{ $wal->symbol }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start align-items-center mt-1">
                                @if (!Request::is('**/funding/**'))
                                    @if ($provider == 'kucoin')
                                        @if ($wallets != null)
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deposit"
                                                class="btn btn-success"><i class="bi bi-wallet2"></i>
                                                {{ __('locale.Deposit') }}</button>
                                        @else
                                            <form method="POST" action="{{ route('user.wallet.regenerate') }}">
                                                @csrf
                                                <input type="hidden" id="symbol" name="symbol"
                                                    value="{{ $wal->symbol }}">
                                                <button type="submit" class="btn btn-success"><i
                                                        class="bi bi-arrow-clockwise"></i>
                                                    {{ __('locale.Regenerate') }}</button>
                                            </form>
                                        @endif
                                    @else
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deposit"
                                            class="btn btn-success"><i class="bi bi-wallet2"></i>
                                            {{ __('locale.Deposit') }}</button>
                                    @endif
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#withdraw"
                                        class="btn btn-danger ms-1"><i class="bi bi-cash-coin"></i>
                                        {{ __('locale.Withdraw') }}</button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#transfer_trading"
                                        class="btn btn-warning ms-1"><i class="bi bi-arrow-left-right"></i>
                                        {{ __('locale.Transfer') }}</button>
                                @else
                                    <a href="{{ route('user.deposit') }}"><button class="btn btn-success"><i
                                                class="bi bi-wallet2"></i> {{ __('locale.Deposit') }}</button></a>
                                    <a href="{{ route('user.withdraw', $wal->symbol) }}"><button
                                            class="btn btn-danger ms-1"><i class="bi bi-cash-coin"></i>
                                            {{ __('locale.Withdraw') }}</button></a>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#transfer_funding"
                                        class="btn btn-warning ms-1"><i class="bi bi-arrow-left-right"></i>
                                        {{ __('locale.Transfer') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="deposit" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            @if ($provider == 'kucoin')
                                @if ($wallets != null)
                                    <div class="modal-content">
                                        <div class="modal-header bg-transparent">
                                            <h5 class="modal-title">{{ __('locale.Select Deposit Network') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach ($wallets as $chain => $wall)
                                                <li class="nav-item">
                                                    <a class="nav-link @if ($a == 0) active @endif"
                                                        id="{{ $chain }}-tab" data-bs-toggle="tab"
                                                        href="#{{ $chain }}" aria-controls="{{ $chain }}"
                                                        role="tab" aria-selected="false">{{ $chain }}</a>
                                                </li>
                                                @php $a++ @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @php $i=0; @endphp
                                            @foreach ($wallets as $chain => $wall)
                                                <div class="tab-pane @if ($i == 0) active @endif"
                                                    id="{{ $chain }}" aria-labelledby="{{ $chain }}-tab"
                                                    role="tabpanel">
                                                    <form class="add-new-record modal-content pt-0" method="POST"
                                                        action="{{ route('user.wallet.deposit') }}">
                                                        @csrf
                                                        <input type="hidden" name="symbol"
                                                            value="{{ $wall->currency ?? '' }}">
                                                        <input type="hidden" name="memo" value="{{ $wall->tag ?? '' }}">
                                                        <input type="hidden" name="chain" value="{{ $chain ?? '' }}">
                                                        <div class="modal-body pb-3 px-sm-3">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-4">
                                                                    <div><label
                                                                            class="form-control-label h6">{{ __('locale.To') }}</label>
                                                                    </div>
                                                                    {!! QrCode::size(128)->generate($wall->address ?? 'non') !!}
                                                                </div>
                                                                <div class="col-lg-9 col-md-8">
                                                                    <div>
                                                                        <label class="form-control-label h6"
                                                                            for="recieving_address">{{ __('locale.Wallet Address') }}</label>
                                                                        <input class="form-control" type="text"
                                                                            name="recieving_address"
                                                                            value="{{ $wall->address ?? '' }}" readonly>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mt-1">
                                                                        <span>{{ __('locale.Transfer Limit') }}</span>
                                                                        <span>{{ __('locale.Unlimited') }}</span>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>{{ __('locale.Memo') }}</span>
                                                                        <span>{{ $wall->tag ?? '' }}</span>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                            <div class="mt-1">{{ __('locale.This is a') }}
                                                                <span class="text-info">{{ $chain ?? '' }}</span>
                                                                {{ __('locale.Chain address. Do not send any other Chain to this address or your funds may be lost.') }}
                                                            </div>
                                                            <hr>
                                                            <div class="input-group">
                                                                <span class="input-group-text"
                                                                    for="address">{{ __('locale.Transaction Hash') }}</span>
                                                                <input type="text" class="form-control" name="address">
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-end">
                                                            <button type="submit" class="btn btn-success">Deposit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                @php $i++ @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="add-new-record modal-content pt-0" method="POST"
                                        action="{{ route('user.wallet.deposit') }}">
                                        @csrf
                                        <input type="hidden" name="symbol" value="{{ $wal->symbol }}">
                                        <div class="modal-body pb-3 px-sm-3">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4">
                                                    <div><label
                                                            class="form-control-label h6">{{ __('locale.To') }}</label>
                                                    </div>
                                                    {!! QrCode::size(128)->generate($wal->address) !!}
                                                </div>
                                                <div class="col-lg-9 col-md-8">
                                                    <div>
                                                        <label class="form-control-label h6"
                                                            for="recieving_address">{{ __('locale.Wallet Address') }}</label>
                                                        <input class="form-control" type="text" name="recieving_address"
                                                            value="{{ $wal->address }}">
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-1">
                                                        <span>Transfer Limit</span>
                                                        <span>Unlimited</span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Processing Time</span>
                                                        <span>{{ $currency->network_confirmations }}</span>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="mt-1">{{ __('locale.This is a') }} <span
                                                    class="text-info">{{ $wal->chain }}</span>
                                                {{ __('locale.Chain address. Do not send any other Chain to this address or your funds may be lost.') }}
                                            </div>
                                            <hr>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    for="address">{{ __('locale.Transaction Hash Address') }}</span>
                                                <input type="text" class="form-control" name="address">
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="submit" class="btn btn-success">Deposit</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="withdraw" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5 class="modal-title">{{ __('locale.Select Withdraw Network') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                @if ($provider == 'kucoin')
                                    @if ($chains != null)
                                        <ul class="nav nav-tabs" role="tablist">
                                            @php $b=0; @endphp
                                            @foreach ($chains as $chain)
                                                <li class="nav-item">
                                                    <a class="nav-link @if ($b == 0) active @endif"
                                                        id="{{ $chain['chainName'] }}-withdraw-tab" data-bs-toggle="tab"
                                                        href="#{{ $chain['chainName'] }}-withdraw"
                                                        aria-controls="{{ $chain['chainName'] }}-withdraw" role="tab"
                                                        aria-selected="false">{{ $chain['chainName'] }}</a>
                                                </li>
                                                @php $b++ @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @php $c=0; @endphp
                                            @foreach ($chains as $chain)
                                                <div class="tab-pane @if ($c == 0) active @endif"
                                                    id="{{ $chain['chainName'] }}-withdraw"
                                                    aria-labelledby="{{ $chain['chainName'] }}-withdraw-tab"
                                                    role="tabpanel">
                                                    <form class="add-new-record modal-content pt-0" method="POST"
                                                        action="{{ route('user.wallet.withdraw') }}">
                                                        @csrf
                                                        <div class="modal-body pb-3 px-sm-3">
                                                            <input type="hidden" name="symbol"
                                                                value="{{ $wal->symbol }}">
                                                            <input type="hidden" name="chain"
                                                                value="{{ $chain['chainName'] }}">
                                                            <div class="mt-1">{{ __('locale.Provide a') }}
                                                                <span
                                                                    class="text-info">{{ $chain['chainName'] }}</span>
                                                                {{ __('locale.Chain address. Do not add any other Chain to this address or your funds may be lost.') }}
                                                            </div>
                                                            <hr>
                                                            <div class="input-group">
                                                                <span class="input-group-text"
                                                                    for="recieving_address">{{ __('locale.Wallet Address') }}</span>
                                                                <input type="text" class="form-control"
                                                                    name="recieving_address">
                                                            </div>
                                                            <div class="input-group my-1">
                                                                <span class="input-group-text"
                                                                    for="amount">{{ __('locale.Amount') }}</span>
                                                                <input type="number" class="form-control" name="amount"
                                                                    min="{{ $chain['withdrawalMinSize'] }}"
                                                                    step="{{ $chain['withdrawalMinSize'] / 10 }}">
                                                            </div>
                                                            <div class="my-1">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"
                                                                        for="amount">{{ __('locale.Memo') }}</span>
                                                                    <input type="text" class="form-control" name="memo">
                                                                </div>
                                                                <small class="text-warning">Leave empty if the network
                                                                    chain dont require memo</small>
                                                            </div>
                                                            <div class="input-group my-1">
                                                                <span class="input-group-text"
                                                                    for="amount">{{ __('locale.Fees') }}</span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $chain['withdrawalMinFee'] }} {{ $wal->symbol }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-end">
                                                            <button type="submit" class="btn btn-success">Withdraw</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                @php $c++ @endphp
                                            @endforeach
                                        </div>
                                    @endif
                                @else
                                    <form class="add-new-record modal-content pt-0" method="POST"
                                        action="{{ route('user.wallet.withdraw') }}">
                                        @csrf
                                        <div class="modal-body pb-3 px-sm-3">
                                            <input type="hidden" name="symbol" value="{{ $wal->symbol }}">
                                            <div class="mt-1">{{ __('locale.Provide a') }} <span
                                                    class="text-info">{{ $wal->chain }}</span>
                                                {{ __('locale.Chain address. Do not add any other Chain to this address or your funds may be lost.') }}
                                            </div>
                                            <hr>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    for="recieving_address">{{ __('locale.Wallet Address') }}</span>
                                                <input type="text" class="form-control" name="recieving_address">
                                            </div>
                                            <div class="input-group my-1">
                                                <span class="input-group-text"
                                                    for="amount">{{ __('locale.Amount') }}</span>
                                                <input type="number" class="form-control" name="amount"
                                                    min="{{ $min }}" step="{{ $min / 10 }}">
                                            </div>
                                            <div class="my-1">
                                                <div class="input-group">
                                                    <span class="input-group-text"
                                                        for="amount">{{ __('locale.Memo') }}</span>
                                                    <input type="text" class="form-control" name="memo">
                                                </div>
                                                <small class="text-warning">Leave empty if no memo</small>
                                            </div>
                                            <div class="input-group my-1">
                                                <span class="input-group-text"
                                                    for="amount">{{ __('locale.Fees') }}</span>
                                                <input type="text" class="form-control"
                                                    value="{{ $curr->fee * (1 + getGen()->provider_withdraw_fee / 100) }} {{ $wal->symbol }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="submit" class="btn btn-success">Withdraw</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="transfer_trading" tabindex="-1" aria-labelledby="transfer"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="add-new-record modal-content pt-0" method="POST"
                                    action="{{ route('user.wallet.transfer.trading') }}">
                                    @csrf
                                    <div class="modal-body pb-3 px-sm-3">
                                        <input type="hidden" name="symbol" value="{{ $wal->symbol }}">
                                        <div class="input-group my-1">
                                            <span class="input-group-text"
                                                for="amount">{{ __('locale.Amount') }}</span>
                                            <input type="text" class="form-control" name="amount">
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-success">Transfer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="transfer_funding" tabindex="-1" aria-labelledby="transfer"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="add-new-record modal-content pt-0" method="POST"
                                    action="{{ route('user.wallet.transfer.funding') }}">
                                    @csrf
                                    <div class="modal-body pb-3 px-sm-3">
                                        <input type="hidden" name="symbol" value="{{ $wal->symbol }}">
                                        <div class="input-group my-1">
                                            <span class="input-group-text"
                                                for="amount">{{ __('locale.Amount') }}</span>
                                            <input type="text" class="form-control" name="amount">
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-success">Transfer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0" id="table-hover-row" style="overflow:auto;">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.Wallet Transactions') }}</h4>
                        </div>
                        <div class="table-responsive" style="min-height:50vh;max-height:50vh;overflow-y:auto;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.Type') }}</th>
                                        <th>{{ __('locale.Info') }}</th>
                                        <th>{{ __('locale.Transaction') }}</th>
                                        <th>{{ __('locale.Status') }}</th>
                                        @if (Request::is('**/trading/*'))
                                            @if ($provider == 'coinbasepro')
                                                <th>{{ __('locale.Actions') }}</th>
                                            @endif
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (Request::is('**/trading/*'))
                                        @php $type = 'trading'; @endphp
                                    @else
                                        @php $type = 'funding'; @endphp
                                    @endif
                                    @forelse ($wal_trx->where('wallet_type',$type)->where('user_id',auth()->user()->id) as $trx)
                                        <tr>
                                            <td>
                                                <div class="avatar bg-light-primary rounded float-start">
                                                    <div class="avatar-content">
                                                        @if ($trx->type == 1)
                                                            <span class="text-success fs-3"><i
                                                                    class="bi bi-wallet2"></i></span>
                                                        @elseif($trx->type == 2)
                                                            <span class="text-danger fs-3"><i
                                                                    class="bi bi-cash"></i></span>
                                                        @elseif($trx->type == 3)
                                                            <span class="text-success fs-3"><i
                                                                    class="bi bi-send"></i></span>
                                                        @elseif($trx->type == 4)
                                                            <span class="text-warning fs-3"><i
                                                                    class="bi bi-envelope"></i></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><span class="text-warning">{{ __('locale.Amount') }}:</span>
                                                    @if ($trx->amount != 0)
                                                        {{ ttz($trx->amount) }} {{ $wal->symbol }}
                                                </div>
                                            @else
                                                <span
                                                    class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                    @endif
                                    <div><span class="text-warning">{{ __('locale.Charge') }}:</span>
                                        @if ($trx->charge != 0)
                                            {{ ttz($trx->charge) }} {{ $wal->symbol }}
                                    </div>
                                @else
                                    <span
                                        class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
        @endif
        <div><span class="text-warning">{{ __('locale.Recieved') }}:</span>
            @if ($trx->amount_recieved != 0)
                {{ ttz($trx->amount_recieved) }} {{ $wal->symbol }}
        </div>
    @else
        <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
        @endif
        @if ($trx->type == 2)
            <div><span class="text-warning">{{ __('locale.Processing Fees') }}:</span>
                {{ ttz($trx->fees) }} {{ $wal->symbol }}</div>
        @endif
        @if ($provider == 'kucoin')
            @if ($trx->chain != null)
                <div><span class="text-warning">{{ __('locale.Chain') }}:</span>
                    {{ $trx->chain }}</div>
            @endif
        @endif
        </td>
        <td>
            @if ($trx->type == 1)
                <div class="avatar-group">
                    <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
                    <div class="my-0 mx-2 text-success fs-3 ms-q" style=""><i class="bi bi-arrow-right"></i></div>
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0" title="{{ $trx->symbol }}">
                        <img class="avatar-content"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($trx->symbol) . '.png') }}"
                            alt="Avatar" />
                    </div>
                </div>
            @elseif ($trx->type == 2)
                <div class="avatar-group">
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0" title="{{ $trx->address }}">
                        <img class="avatar-content"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wal->symbol) . '.png') }}"
                            alt="Avatar" />
                    </div>
                    <div class="my-0 mx-2 text-success fs-3 ms-1" style=""><i class="bi bi-arrow-right"></i></div>
                    <span class="text-success fs-3"><i class="bi bi-wallet2"></i></span>
                </div>
            @elseif ($trx->type == 3)
                <div class="avatar-group">
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0" title="{{ $trx->address }}">
                        <img class="avatar-content"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wal->symbol) . '.png') }}"
                            alt="Avatar" />
                    </div>
                    <div
                        class="my-0 mx-2 @if ($trx->status == 1) text-success @elseif($trx->status == 2) text-warning @else text-danger @endif fs-3 ms-1">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0" title="{{ $trx->to }}">
                        <span class="avatar-content fs-3"><i class="bi bi-person"></i></span>
                    </div>
                </div>
            @else
                <div class="avatar-group">
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0 " title="{{ $trx->address }}">
                        <span class="avatar-content fs-3"><i class="bi bi-person"></i></span>
                    </div>
                    <div
                        class="my-0 me-2 @if ($trx->status == 1) text-success @elseif($trx->status == 2) text-warning @else text-danger @endif fs-3 ms-1">
                        <i class="bi bi-arrow-left"></i>
                    </div>
                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar pull-up my-0" title="{{ $trx->to }}">
                        <img class="avatar-content"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($wal->symbol) . '.png') }}"
                            alt="Avatar" />
                    </div>
                </div>
            @endif
        </td>
        <td>
            @if ($trx->status == 1)
                <span class="badge rounded-pill badge-light-success me-1">{{ __('locale.Completed') }}</span>
            @elseif($trx->status == 2)
                <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
            @elseif($trx->status == 3)
                <span class="badge rounded-pill badge-light-danger me-1">{{ __('locale.Rejected') }}</span>
            @endif
        </td>

        @if (Request::is('**/trading/*'))
            @if ($provider == 'coinbasepro')
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical fs-4"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" target="_blank" href="{{ $cur_link }}{{ $trx->to }}">
                                <i class="bi bi-chevron-right"></i><span> {{ __('locale.View Transaction') }}</span>
                            </a>
                        </div>
                    </div>
                </td>
            @endif
        @endif
        </tr>
    @empty
        <tr>
            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
        </tr>
        @endforelse
        </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    <div class="modal modal-slide-in fade" id="send">
        <div class="modal-dialog sidebar-sm">
            <form class="add-new-record modal-content pt-0" action="{{ route('user.wallet.send') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="from" name="from" value="{{ $wal->address }}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="send1">{{ __('locale.Send Payment') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="to">{{ __('locale.Reciever Wallet') }}</label>
                        <input type="text" class="form-control to" id="to" maxlength="80" name="to"
                            value="{{ old('to') }}" placeholder="{{ __('locale.Reciever Wallet') }}" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="amount">{{ __('locale.Amount') }}</label>
                        <input type="text" class="form-control amount" id="amount" maxlength="30" name="amount"
                            value="{{ old('amount') }}" placeholder="{{ __('locale.Amount') }}" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="details">{{ __('locale.Details') }}</label>
                        <input type="text" class="form-control details" id="details" maxlength="30" name="details"
                            value="{{ old('details') }}" placeholder="{{ __('locale.Details') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Send') }}</button>
                    <button type="reset" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal modal-slide-in fade" id="request">
        <div class="modal-dialog sidebar-sm">
            <form class="add-new-record modal-content pt-0" action="{{ route('user.wallet.request') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="to" name="to" value="{{ $wal->address }}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="request1">{{ __('locale.Request') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="from">{{ __('locale.Request From Wallet') }}</label>
                        <input type="text" class="form-control from" id="from" maxlength="80" name="from"
                            value="{{ old('from') }}" placeholder="{{ __('locale.Wallet') }}" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="amount">{{ __('locale.Amount') }}</label>
                        <input type="text" class="form-control amount" id="amount" maxlength="30" name="amount"
                            value="{{ old('amount') }}" placeholder="{{ __('locale.Amount') }}" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="details">{{ __('locale.Details') }}</label>
                        <input type="text" class="form-control details" id="details" maxlength="30" name="details"
                            value="{{ old('details') }}" placeholder="{{ __('locale.Details') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Request') }}</button>
                    <button type="reset" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
        <div class="card">
        </div>
    </div>
    @endif
    </div>
@endsection
