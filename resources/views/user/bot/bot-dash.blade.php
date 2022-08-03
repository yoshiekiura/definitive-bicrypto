@extends('layouts.app')
@section('page-style')

  <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css'))}}">
@endsection
@section('content')
<div class="row match-height">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-congratulation-medal mh-22vh">
            <div class="card-body">
                <h5>{{ __('locale.Welcome')}} 🎉 {{auth()->user()->firstname}}</h5>
                <a href="{{route('user.bot.market')}}" type="button" class="mt-3 btn btn-primary">{{ __('locale.New Bot')}}</a>
                <img src="{{asset('images/illustration/badge.svg')}}" class="congratulation-medal"
                    alt="Medal Pic" />
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="row">
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i class="bi bi-robot font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder">{{$bot_contracts_count->where('status','!=',1)->count()}}</h2>
                        <p class="card-text">{{ __('locale.Running Bots')}}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-success p-50 mb-1">
                            <div class="avatar-content">
                                <i class="bi bi-check-lg font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder">{{$bot_contracts_count->where('status',1)->count()}}</h2>
                        <p class="card-text">{{ __('locale.Completed Bots')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="row">
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i class="bi bi-robot font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder">{{$bot_contracts_count->sum('amount') * getCurrency()->rate}} {{getCurrency()->symbol}}</h2>
                        <p class="card-text">{{ __('locale.Total Investment')}}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-success p-50 mb-1">
                            <div class="avatar-content">
                                <i class="bi bi-check-lg font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder @if ($profit > 0) text-success @elseif($profit < 0) text-danger @else @endif">{{$profit * getCurrency()->rate}} {{getCurrency()->symbol}}</h2>
                        <p class="card-text">{{ __('locale.Total Profit/Lose')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="@if ($gnl->referal_status == 1)col-lg-9 @else col-lg-12 @endif col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Your Bots')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive" style="max-height:280px;overflow-y:auto;">
                <table class="table custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Bot')}}</th>
                            <th scope="col">{{ __('locale.Duration')}}</th>
                            <th scope="col">{{ __('locale.Profit/Loses')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                            <th scope="col">{{ __('locale.View')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bot_contracts as $bot)
                            <tr>
                                <td data-label="{{ __('locale.Bot')}}">
                                    <div class="fw-bold fs-4">{{ $bot->bot_name }}</div>
                                    <small class="text-warning">({{ $bot->symbol }}/{{ $bot->pair }})</small>
                                </td>
                                <td data-label="{{ __('locale.Duration')}}">
                                    <div> {{ __('locale.Start')}}: <span class="fw-bold">{{showDateTime($bot->start_date, 'd M, Y h:i:s')}}</span></div>
                                    <div> {{ __('locale.End')}}: <span class="fw-bold">{{showDateTime($bot->end_date, 'd M, Y h:i:s')}}</span></div>
                                </td>
                                <td data-label="{{ __('locale.Profit/Loses')}}">
                                    @if ($bot->status == 1)
                                        <div class="fw-bold @if ($bot->result == 1) text-success @elseif($bot->result == 2) text-danger @else @endif">@if ($bot->result == 1) + @elseif($bot->result == 2) - @else @endif{{ ttz($bot->profit) }} {{ $bot->pair }}</div>
                                    @else
                                        @if($platform->bot->data == 1)
                                            <div id="bot_fad_{{$bot->id}}">
                                            <script>
                                                setInterval(function gRI_{{$bot->id}}() {
                                                    min_{{$bot->id}} = Math.ceil("{{ $bot->amount - (($bot->amount * $bot->min_profit) / 100) }}");
                                                    max_{{$bot->id}} = Math.floor("{{ $bot->amount + (($bot->amount * $bot->max_profit) / 100) }}");
                                                    bot_d_{{$bot->id}} = document.getElementById('bot_fad_{{$bot->id}}');
                                                    bot_c_{{$bot->id}} = Math.floor(Math.random() * (max_{{$bot->id}} - min_{{$bot->id}})) + min_{{$bot->id}};
                                                    bot_a_{{$bot->id}} = "{{ $bot->amount }}";
                                                    bot_p_{{$bot->id}} = "{{ $bot->pair }}";
                                                    if (bot_c_{{$bot->id}} > bot_a_{{$bot->id}}){
                                                        bot_d_{{$bot->id}}.innerHTML = bot_c_{{$bot->id}} + '<i class="bi bi-arrow-up"></i>' + ' (' + bot_p_{{$bot->id}} + ')';
                                                        bot_d_{{$bot->id}}.style.color = 'rgb(14,203,129)';
                                                    } else if (bot_c_{{$bot->id}} < bot_a_{{$bot->id}}){
                                                        bot_d_{{$bot->id}}.innerHTML = bot_c_{{$bot->id}} + '<i class="bi bi-arrow-down"></i>' + ' (' + bot_p_{{$bot->id}} + ')';
                                                        bot_d_{{$bot->id}}.style.color = 'rgb(246,70,93';
                                                    } else {
                                                        bot_d_{{$bot->id}}.innerHTML = bot_c_{{$bot->id}} + ' (' + bot_p_{{$bot->id}} + ')';
                                                        bot_d_{{$bot->id}}.style.color = 'dark';
                                                    }
                                                }, (Math.random() * 3) * 2500);
                                            </script>
                                        @elseif ($platform->bot->data == 0)
                                            <div id="show_{{$bot->id}}"></div>
                                            <div id="show_c_{{$bot->id}}"></div>
                                            <script>
                                                "use strict";
                                                let ws_i_{{$bot->id}} = new WebSocket('wss://stream.binance.com:9443/ws/{{strtolower($bot->symbol)}}{{strtolower($bot->pair)}}@miniTicker');
                                                let el_b_{{$bot->id}} = document.getElementById('show_{{$bot->id}}');
                                                let el_c_{{$bot->id}} = document.getElementById('show_c_{{$bot->id}}');
                                                let last_b_{{$bot->id}} = null;
                                                let last_c_{{$bot->id}} = null;
                                                let a_{{$bot->id}} = "{{ $bot->start_price }}";
                                                ws_i_{{$bot->id}}.onmessage = function (event_{{$bot->id}}) {
                                                    let data_{{$bot->id}} = JSON.parse(event_{{$bot->id}}.data);
                                                    let b_{{$bot->id}} = parseFloat(data_{{$bot->id}}.c);
                                                    el_b_{{$bot->id}}.innerText = b_{{$bot->id}};
                                                    if (b_{{$bot->id}} < last_b_{{$bot->id}}) {
                                                        el_b_{{$bot->id}}.innerHTML = b_{{$bot->id}} + '<i class="bi bi-arrow-down"></i>';
                                                        el_b_{{$bot->id}}.style.color = 'rgb(246,70,93';
                                                    } else if (b_{{$bot->id}} > last_b_{{$bot->id}}) {
                                                        el_b_{{$bot->id}}.innerHTML = b_{{$bot->id}} + '<i class="bi bi-arrow-up"></i>';
                                                        el_b_{{$bot->id}}.style.color = 'rgb(14,203,129)';
                                                    } else {
                                                        el_b_{{$bot->id}}.innerText = b_{{$bot->id}};
                                                        el_b_{{$bot->id}}.style.color = 'dark';
                                                    }
                                                    last_b_{{$bot->id}} = b_{{$bot->id}};
                                                    let c_{{$bot->id}} = b_{{$bot->id}}/a_{{$bot->id}};
                                                    el_c_{{$bot->id}}.innerText = (c_{{$bot->id}}).toFixed(2);
                                                    if (c_{{$bot->id}} < last_c_{{$bot->id}}) {
                                                        el_c_{{$bot->id}}.innerHTML = (c_{{$bot->id}}).toFixed(2) + '%';
                                                        el_c_{{$bot->id}}.style.color = 'rgb(246,70,93';
                                                    } else if (c_{{$bot->id}} > last_c_{{$bot->id}}) {
                                                        el_c_{{$bot->id}}.innerHTML = (c_{{$bot->id}}).toFixed(2) + '%';
                                                        el_c_{{$bot->id}}.style.color = 'rgb(14,203,129)';
                                                    } else {
                                                        el_c_{{$bot->id}}.innerText = (c_{{$bot->id}}).toFixed(2);
                                                        el_c_{{$bot->id}}.style.color = 'dark';
                                                    }
                                                    last_c_{{$bot->id}} = c_{{$bot->id}};
                                                };
                                            </script>
                                        @endif
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Status')}}">
                                    @if($bot->status != 1)
                                    <span class="badge bg-warning">{{ __('locale.Running')}}</span>
                                    @elseif($bot->status == 1)
                                    <span class="badge bg-success">{{ __('locale.Completed')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.View')}}">
                                    @if($bot->status != 1)
                                    <a href="{{ route('user.bot.now',[$bot->symbol,$bot->pair]) }}"
                                        class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('locale.View')}}">
                                            <i class="bi bi-display"></i>
                                        </a>
                                    @endif
                                </td>
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
        <div class="mb-1">{{ paginateLinks($bot_contracts) }}</div>
    </div>
    @if ($gnl->referal_status == 1)
    <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-gift text-warning font-large-2 mb-1"></i>
                <h5 class="card-title">{{ __('locale.Refer & Earn')}}</h5>
                <p class="card-text">
                    {{ __('locale.Refer your friends & Earn for 5% of every customer that complete 1 deposit in the platform.')}}
                </p>
                <!-- modal trigger button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#referEarnModal">
                    {{ __('locale.Invite')}}
                </button>
            </div>
        </div>
        @include('user/partials/refer-earn')
    </div>
    @endif
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
