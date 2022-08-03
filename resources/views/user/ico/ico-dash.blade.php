@extends('layouts.app')
@section('page-style')

  <link rel="stylesheet" href="{{ asset(mix('/vendors/css/flipclock/flipclock.min.css'))}}">
@endsection
@section('content')
<div class="row match-height">
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card card-profile">
            <img src="{{asset('assets/images/ico/stage-3.jpg')}}" class="card-img-top card-img-fit-194px"
                alt="Profile Cover Photo" />
            <div class="card-body">
                <div class="profile-image-wrapper">
                    <div class="profile-image">
                        <div class="avatar">
                            <img class="round"
                                src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('images/portrait/small/avatar-s-11.jpg') }}"
                                alt="avatar">
                        </div>
                    </div>
                </div>
                <h3>{{auth()->user()->firstname}}</h3>
                <h6 class="badge badge-light-success profile-badge">{{ __('Verified Trader') }}</h6>
                <span class="badge badge-light-primary profile-badge">{{ __('Pro Level') }}</span>
            </div>
        </div>
        <div class="card border-0 text-white img-cover"
            style="background: url({{asset('assets/images/ico/stage-2.jpg')}});">
            <div class="card-img-overlay bg-overlay">
                <div class="card-title">{{ __('Wallet Address') }}</div>
                <div
                    class="w-100 p-1 pe-3 d-flex justify-content-between align-items-center position-absolute bottom-0">
                    @if ($meta == 'Not Added Yet')
                        <div>{{ __('Add your wallet address') }}</div>
                        <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal"
                            data-bs-target="#addWalletModal">{{ __('Add') }}</button>
                    @else
                        <div class="col-9">
                            <input class="form-control text-dark" type="text" value="{{ $meta->rec_wallet }}"
                            aria-label="{{ $meta->rec_wallet }}" disabled readonly>
                        </div>
                        <div class="col-3">

                        <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal"
                        data-bs-target="#changeWalletModal">{{ __('Change') }}</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 text-white img-cover"
            style="background: url({{asset('assets/images/ico/stage-0.jpg')}});">
            <div class="card-img-overlay bg-overlay">
                <h4 class="card-title text-white">{{ __('locale.Token Balance') }}</h4>
                <div class="d-flex justify-content-between rounded bg-wallet p-1 mx-1">
                    <div class="avatar">
                        <img src="{{getImage('assets/images/ico/'.$ico->image)}}">
                    </div>
                    <div class="text-white">
                        <h3 class="text-white">{{ getAmount($ico_balance) }} {{ $ico->symbol }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-transaction">
            <img src="{{asset('assets/images/ico/header.gif')}}" class="card-img-top card-img-fit-160px"
                alt="Profile Cover Photo" />
            <div class="card-body mh-280">
                @if ($ico_logs == 'null')
                <p>{{ __('locale.Start your adventure with us by contributing to our brand token with unlimited possibilites.') }}
                </p>
                <p>{{ __('locale.Every level you advance in adventure will boost your profit with us.') }}</p>
                <p>{{ __('locale.Higher Stages will have higher bonuses in our services.') }}</p>
                @else
                @foreach ($ico_logs as $log)
                <div class="transaction-item">
                    <div class="d-flex">
                        <div class="avatar bg-light-primary rounded float-start">
                            <div class="avatar-content">
                                @if($log->status == 1)
                                <span class="text-success font-medium-5"><i class="bi bi-graph-up-arrow"></i></span>
                                @elseif($log->status == 2)
                                <span class="text-danger font-medium-5"><i class="bi bi-graph-down-arrow"></i></span>
                                @else
                                <span class="text-warning font-medium-5"><i class="bi bi-slash-lg"></i></span>
                                @endif
                            </div>
                        </div>
                        <div class="transaction-percentage">
                            <h6 class="transaction-title">
                                @if($log->status == 1)
                                <span class="text-success">{{ __('locale.Token Purchase')}}</span>
                                @elseif($log->status == 0)
                                <span class="text-danger">{{ __('locale.Pending Purchase')}}</span>
                                @endif
                            </h6>
                            <small>{{ getAmount($log->amount) }} {{ $log->from_symbol}}</small>
                        </div>

                    </div>
                    <div class="fw-bolder">
                        @if($log->status == 1)
                        <span class="badge bg-success">+ {{getAmount($log->ico_amount)}} {{$ico->symbol}}</span>
                        @elseif($log->status == 2)
                        <span class="badge bg-danger">- {{getAmount($log->ico_amount)}} {{$ico->symbol}}</span>
                        @else
                        <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-12">
        <div class="section text-center py-5 py-md-0">
            <input class="pricing1111 mt-1" type="checkbox" id="pricing" name="pricing" style="position: absolute;left: -9999px;"/>
            <label for="pricing"><span class="block-diff">{{ __('locale.Offering')}}<span
                        class="float-end">{{ __('locale.Launching')}}</span></span></label>
            <div class="card-3d-wrap1111 mx-auto mt-3">
                <div class="card-3d-wrapper1111">
                    <div class="card-front1111">
                        <div class="pricing-wrap1111">
                            <h4 class="mb-3 mt-1">{{ __('locale.Offering')}}</h4>
                            @if ($ico->stage == 0)
                            <div class="clock"></div>
                            @endif
                            <h2 class="my-1"><sup></sup>1 {{ $ico->symbol }}<sup> = {{ getAmount($ico->offer_price) }}
                                    USD</sup></h2>
                            <small class="px-1 d-flex justify-content-between text-black">
                                <span>{{ __('locale.Raised Tokens')}}</span>
                                <span>{{ __('locale.Total Tokens')}}</span>
                            </small>
                            <small class="px-1 d-flex justify-content-between text-black">
                                <span>{{ getAmount($ico->offer_raised) }} {{ $ico->symbol }}</span>
                                <span>{{ getAmount($ico->offer_quantity) }} {{ $ico->symbol }}</span>
                            </small>
                            <div class="px-1 mb-1">
                                <div id="myRangeColor" class="progress">
                                    <div id="myRange" class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ ($ico->offer_raised / $ico->offer_quantity) * 100 }}%"></div>
                                </div>
                            </div>
                            @if ($ico->stage == 0)
                            @if (isset($meta->rec_wallet))
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#buyTokenModal">{{ __('locale.Buy Tokens')}}</button>
                            @else
                            <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal"
                                data-bs-target="#addWalletModal">{{ __('Add Wallet First') }}</button>
                            @endif
                            @endif
                            <div class="img-wrap img-2">
                                <img src="{{asset('assets/images/ico/grass.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-4">
                                <img src="{{asset('assets/images/ico/camp.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-5">
                                <img src="{{asset('assets/images/ico/Ivy.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-7" style="@if ($ico->stage == 1)bottom: -165px;@endif">
                                <img src="{{asset('assets/images/ico/IvyRock.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-back1111">
                        <div class="pricing-wrap1111">
                            <h4 class="mb-3 mt-1">{{ __('locale.Launching')}}</h4>
                            @if ($ico->stage == 1)
                            <div class="clock clock_launch"></div>
                            @endif
                            <h2 class="my-1"><sup></sup>1 {{ $ico->symbol }}<sup> = {{ getAmount($ico->launch_price) }}
                                    USD</sup></h2>
                            <small class="px-1 d-flex justify-content-between text-black">
                                <span>{{ __('locale.Raised Tokens')}}</span>
                                <span>{{ __('locale.Total Tokens')}}</span>
                            </small>
                            <small class="px-1 d-flex justify-content-between text-black">
                                <span>{{ getAmount($ico->launch_raised) }} {{ $ico->symbol }}</span>
                                <span>{{ getAmount($ico->launch_quantity) }} {{ $ico->symbol }}</span>
                            </small>
                            <div class="px-1 mb-1">
                                <div id="myRangeColor" class="progress">
                                    <div id="myRange" class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ getAmount($ico->launch_raised / $ico->launch_quantity) }}%">
                                    </div>
                                </div>
                            </div>
                            @if ($ico->stage == 1)
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#buyTokenModal">{{ __('locale.Buy Tokens')}}</button>
                            @endif
                            <div class="img-wrap img-2">
                                <img src="{{asset('assets/images/ico/sea.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-1">
                                <img src="{{asset('assets/images/ico/kayak.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-3">
                                <img src="{{asset('assets/images/ico/water.png')}}" alt="">
                            </div>
                            <div class="img-wrap img-6" style="@if ($ico->stage == 0)bottom: -165px;@endif">
                                <img src="{{asset('assets/images/ico/Stone.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-slide-in fade" id="addWalletModal">
    <div class="modal-dialog sidebar-sm">
        <form class="add-new-record modal-content pt-0" action="{{ route('user.ico.wallet.create') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="network_id" id="network_id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Add Wallet')}}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="mb-1">
                    <label class="form-label" for="rec_wallet">{{ __('locale.Your Recieving Wallet')}}</label>
                    <input type="text" class="form-control" id="rec_wallet" maxlength="80" name="rec_wallet"
                        value="{{ old('rec_wallet') }}" placeholder="Wallet" required>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="name">{{ __('locale.Contract Network')}}</label>
                    <div class="dropdown mb-1">
                        <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="network" name="network">
                            {{ __('locale.Select Network')}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-mh" onmouseover="this.size=10;"
                            onmouseout="this.size=1;">
                            @foreach ($networks as $network)
                            <li><a class="dropdown-item" onclick="$('#network').text($(this).text());
                        $('#addWalletModal').find('input[name=network_id]').val($(this).data('network_id'));"
                                    data-network_id="{{ $network->id }}">{{ $network->chainName }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Add')}}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
            </div>
        </form>
    </div>
</div>
<div class="modal modal-slide-in fade" id="changeWalletModal">
    <div class="modal-dialog sidebar-sm">
        <form class="add-new-record modal-content pt-0" action="{{ route('user.ico.wallet.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="network_id" id="network_id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Replace Wallet')}}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="mb-1">
                    <label class="form-label" for="rec_wallet">{{ __('locale.Your Recieving Wallet')}}</label>
                    <input type="text" class="form-control" id="rec_wallet" maxlength="80" name="rec_wallet"
                        value="{{ old('rec_wallet') }}" placeholder="Wallet" required>
                </div>
                <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Update')}}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
            </div>
        </form>
    </div>
</div>
<div class="modal modal-slide-in fade" id="buyTokenModal">
    <div class="modal-dialog sidebar-sm">
        <form class="add-new-record modal-content pt-0" action="{{ route('user.ico.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="ico_id" name="ico_id" value="{{ $ico->id }}">
            <input type="hidden" id="wallet" name="wallet">
            <input type="hidden" id="rec_wallet" name="rec_wallet"
                value="@if(isset($meta->rec_wallet)) {{ $meta->rec_wallet }} @endif">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Buy Tokens')}}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="dropdown mb-1">
                    <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false" id="wallett" name="wallett">
                        {{ __('locale.Select Wallet')}}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if ($wallets != 'null')
                            @foreach ($wallets as $wallet)
                            <li><a class="dropdown-item"
                                    onclick="$('#wallett').text($(this).text());$('#buyTokenModal').find('input[name=wallet]').val($(this).data('wallet'));$('#buyTokenModal').find('span[name=amountSymbol]').text($(this).data('symbol'));"
                                    data-wallet="{{ $wallet->address }}"
                                    data-symbol="{{ $wallet->symbol }}">{{ $wallet->symbol }}
                                    {{ getAmount($wallet->balance) }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @if ($meta == 'Not Added Yet')
                <div>{{ __('locale.Add your wallet address')}}</div>
                <button class="btn btn-sm btn-primary ms-1">{{ __('locale.Add')}}</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#addWalletModal">Add</button>
                @else
                <div class="mb-1">
                    <label class="form-label" for="rec_wallet">{{ __('locale.Your Recieving Wallet')}}</label>
                    <input class="form-control text-white" type="text" value="{{ $meta->rec_wallet }}"
                        aria-label="{{ $meta->rec_wallet }}" name="rec_wallet" disabled readonly>
                </div>
                @endif

                <label class="form-label" for="amount">{{ __('locale.Amount')}}</label>
                <div class="input-group mb-1 w-auto">
                    <input type="number" class="form-control" step=".0000001"
                        onkeyup="$('#ico_amount').val(($(this).val() / @if($ico->stage == 0) {{ $ico->offer_price }} @else {{ $ico->launch_price }}@endif).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('#ico_bonus').val(($(this).val() / @if($ico->stage == 0) {{ $ico->offer_price }} @else {{ $ico->launch_price }}@endif * (@if($ico->stage == 0) {{ $ico->offer_bonus / 100 }} @else {{ $ico->launch_bonus / 100 }}@endif)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                        required="" id="amount" name="amount" placeholder="Amount">
                    <span class="input-group-text text-light" name="amountSymbol" id="amountSymbol"></span>
                </div>

                <label class="form-label" for="ico_amount">{{ __('locale.You Will Recieve')}}</label>
                <div class="input-group mb-1 w-auto">
                    <input type="text" class="form-control" id="ico_amount" readonly disabled>
                    <span class="input-group-text text-light">{{ $ico->symbol }}</span>
                </div>

                <label class="form-label" for="ico_amount">{{ __('locale.Your Bonus')}}</label>
                <div class="input-group mb-1 w-auto">
                    <input type="text" class="form-control" id="ico_bonus" readonly disabled>
                    <span class="input-group-text text-light">{{ $ico->symbol }}</span>
                </div>
                <button type="submit" class="btn btn-success data-submit me-1">{{ __('locale.Buy')}}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('script')
<script src="{{ asset(mix('/vendors/js/moment/moment.min.js'))}}"></script>
<script src="{{ asset(mix('/vendors/js/moment/moment-timezone-with-data-2012-2022.min.js'))}}"></script>
<script src="{{ asset(mix('/vendors/js/flipclock/flipclock.min.js'))}}"></script>
<script>
    $(document).ready(function () {
        var clock;
        var clock_launch;
        // Grab the current date
        var currentDate = new Date();
        var currentDate_launch = new Date();
        // Target future date/24 hour time/Timezone
        var targetDate = moment.tz("{{ $ico->offer_end }}", "Greenwich");
        var targetDate_launch = moment.tz("{{ $ico->launch_end }}", "Greenwich");
        // Calculate the difference in seconds between the future and current date
        var diff = targetDate / 1000 - currentDate.getTime() / 1000;
        var diff_launch = targetDate_launch / 1000 - currentDate_launch.getTime() / 1000;
        if (diff <= 0) {
            // If remaining countdown is 0
            clock = $(".clock").FlipClock(0, {
                clockFace: "DailyCounter",
                countdown: true,
                autostart: false
            });
        } else {
            // Run countdown timer
            clock = $(".clock").FlipClock(diff, {
                clockFace: "DailyCounter",
                countdown: true,
            });
            // Check when timer reaches 0, then stop at 0
            setTimeout(function () {
                checktime();
            }, 1000);
            function checktime() {
                t = clock.getTime();
                if (t <= 0) {
                    clock.setTime(0);
                }
                setTimeout(function () {
                    checktime();
                }, 1000);
            }
        }
        if (diff_launch <= 0) {
            // If remaining countdown is 0
            clock_launch = $(".clock_launch").FlipClock(0, {
                clockFace: "DailyCounter",
                countdown: true,
                autostart: false
            });
        } else {
            // Run countdown timer
            clock_launch = $(".clock_launch").FlipClock(diff_launch, {
                clockFace: "DailyCounter",
                countdown: true,
            });
            // Check when timer reaches 0, then stop at 0
            setTimeout(function () {
                checktime();
            }, 1000);
            function checktime() {
                t = clock_launch.getTime();
                if (t <= 0) {
                    clock_launch.setTime(0);
                }
                setTimeout(function () {
                    checktime();
                }, 1000);
            }
        }
    });
</script>
@endpush
