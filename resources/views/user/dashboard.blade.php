
<ul class="nav nav-tabs border" role="tablist">
    <li class="nav-item w-50">
        <a class="nav-link active" id="practice-tab" data-bs-toggle="tab" href="#practice"
            aria-controls="practice" role="tab">Binary Practice</a>
    </li>
    <li class="nav-item w-50">
        <a class="nav-link" id="trading-tab" data-bs-toggle="tab" href="#trading" aria-controls="trading"
            role="tab">Binary Trading</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="practice" aria-labelledby="practice-tab" role="tabpanel">
        <section id="dashboard-ecommerce">
            <div class="row match-height">
                <!-- Medal Card -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card card-congratulation-medal">
                        <div class="card-body">
                            <h5>{{ __('locale.Welcome') }} 🎉 {{auth()->user()->firstname}}</h5>
                            <p class="card-text font-small-3">{{ __('locale.You have earned') }}</p>
                            <h3 class="mb-75 mt-2 pt-50">
                                <a href="#">{{ getCurrency()->symbol }} {{ number_format($trade['practice_Won'], 2) }}</a>
                            </h3>
                            <a href="{{route('user.binary.practice.market')}}" type="button" class="btn btn-primary">{{ __('locale.Practice Now') }}</a>
                            <img src="{{asset('images/illustration/badge.svg')}}" class="congratulation-medal"
                                alt="Medal Pic" />
                        </div>
                    </div>
                </div>
                <!--/ Medal Card -->
                <!-- Earnings Card -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title mb-2">{{ __('locale.Earnings') }}</h4>
                                    <div class="font-small-3">{{ __('locale.This Week') }}</div>
                                    <h5 class="mb-1">{{ getCurrency()->symbol }} {{ to_num($perc['tradeWon_last_week'], 0, ',', false) }}</h5>
                                    <p class="card-text text-muted font-small-3">
                                        <span class="fw-bolder">{{ $perc['tradeWon_last_week_percentage'] }}%</span><span> {{ __('locale.Won since last week.') }}</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <div id="practice_earnings-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->
                <!-- CCard -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body"
                            style="background: url({{asset('images/slider/wallet.png')}});background-position: right;background-repeat: no-repeat;">
                                <p class="mb-1 fs-14 text-warning">{{ __('locale.Balance') }}</p>
                                <div class="d-flex justify-content-between">
                                    <div class="h2 text-warning mb-1">
                                        {{ getCurrency()->symbol }}
                                        <livewire:partials.practice-balance />
                                    </div>
                                </div>
                                <div class="d-flex mt-1">
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#practiceAmount">+ Top Up</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--/ CCard -->
            </div>

            <div class="row match-height">
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-info p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-bar-chart font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['practice_Log']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Trade Log') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-success p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-graph-up-arrow font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['practice_Win']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Wining Trade') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-warning p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-slash-lg font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['practice_Draw']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Draw Trade') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-danger p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-graph-down-arrow font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['practice_Lose']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Losing Trade') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Report Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="card card-transaction">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.Practice Contracts') }}</h4>
                            {{-- <div class="dropdown chart-dropdown">
                                <i class="bi bi-three-dots-vertical font-medium-3 cursor-pointer"
                                    data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body" style="max-height:280px;overflow-y:auto;">
                            @forelse($practicelogs as $practicelog)
                                <div class="transaction-item">
                                    <div class="d-flex">
                                        <div class="avatar bg-light-primary rounded float-start">
                                            <div class="avatar-content">
                                                @if($practicelog->hilow == 1)
                                                <span class="text-success font-medium-5"><i class="bi bi-graph-up-arrow"></i></span>
                                                @elseif($practicelog->hilow == 2)
                                                <span class="text-danger font-medium-5"><i
                                                        class="bi bi-graph-down-arrow"></i></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <h6 class="transaction-title">
                                                @if($practicelog->hilow == 1)
                                                <span class="text-success">{{ __('locale.Rise')}}</span>
                                                @elseif($practicelog->hilow == 2)
                                                <span class="text-danger">{{ __('locale.Fall')}}</span>
                                                @endif
                                            </h6>
                                            <small>{{__($practicelog->symbol)}} / {{__($practicelog->pair)}}</small>
                                        </div>

                                    </div>
                                    <div class="fw-bolder">
                                        @if($practicelog->result == 1)
                                        <span class="badge bg-success">+ {{getAmount($practicelog->amount * ($gnl->profit / 100))}}
                                            {{$practicelog->pair}}</span>
                                        @elseif($practicelog->result == 2)
                                        <span class="badge bg-danger">- {{getAmount($practicelog->amount)}}
                                            {{$practicelog->pair}}</span>
                                        @elseif($practicelog->result == 3)
                                        <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
                                        @else
                                        <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                            <div colspan="100%"> {{ __('locale.No results found')}}!</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if ($gnl->referal_status == 1)
                <!-- refer and earn card -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body text-center mt-3">
                            <i class="bi bi-gift text-warning font-large-2 mb-1"></i>
                            <h5 class="card-title">{{ __('locale.Refer & Earn') }}</h5>
                            <p class="card-text">
                                {{ __('locale.Refer your friends & Earn for 5% of every customer that complete 1 deposit in the platform.') }}
                            </p>
                            <!-- modal trigger button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#referEarnModal">
                                {{ __('locale.Invite') }}
                            </button>
                        </div>
                    </div>
                </div>
                <!-- / refer and earn card -->
                @include('user/partials/refer-earn')
                @endif
            </div>
        </section>
    </div>
    <div class="tab-pane" id="trading" aria-labelledby="trading-tab" role="tabpanel">
        <section id="dashboard-ecommerce">
            <div class="row match-height">
                <!-- Medal Card -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card card-congratulation-medal">
                        <div class="card-body">
                            <h5>{{ __('locale.Welcome') }} 🎉 {{auth()->user()->firstname}}</h5>
                            <p class="card-text font-small-3">{{ __('locale.You have earned') }}</p>
                            <h3 class="mb-75 mt-2 pt-50">
                                <a href="#">{{ getCurrency()->symbol }} {{ number_format($trade['Won'], 2) }}</a>
                            </h3>
                            <a href="{{route('user.binary.trade.market')}}" type="button" class="btn btn-primary">{{ __('locale.Start Trading') }}</a>
                            <img src="{{asset('images/illustration/badge.svg')}}" class="congratulation-medal"
                                alt="Medal Pic" />
                        </div>
                    </div>
                </div>
                <!--/ Medal Card -->
                <!-- Earnings Card -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title mb-2">{{ __('locale.Earnings') }}</h4>
                                    <div class="font-small-3">{{ __('locale.This Week') }}</div>
                                    <h5 class="mb-1">{{ getCurrency()->symbol }} {{ to_num($perc['tradeWon_last_week'], 0, ',', false) }}</h5>
                                    <p class="card-text text-muted font-small-3">
                                        <span class="fw-bolder">{{ $perc['tradeWon_last_week_percentage'] }}%</span><span> {{ __('locale.Won since last week.') }}</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <div id="earnings-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->
                <!-- CCard -->
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body"
                            style="background: url({{asset('images/slider/wallet.png')}});background-position: right;background-repeat: no-repeat;">
                            <p class="mb-1 fs-14 text-success">{{ __('locale.Balance') }}</p>
                            <div class="d-flex justify-content-between">
                                <div class="h2 text-success mb-1">
                                    {{ getCurrency()->symbol }}
                                    <livewire:partials.balance />
                                </div>
                            </div>
                                <div class="d-flex mt-1">
                                    <a href="{{ route('user.wallet.index') }}" class="btn btn-outline-success">+ Deposit</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="row match-height">
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-info p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-bar-chart font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['Log']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Trade Log') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-success p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-graph-up-arrow font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['Win']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Wining Trade') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-warning p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-slash-lg font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['Draw']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Draw Trade') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="avatar bg-light-danger p-50 mb-1">
                                        <div class="avatar-content">
                                            <i class="bi bi-graph-down-arrow font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder">{{$trade['Lose']}}</h2>
                                    <p class="card-text">{{ __('locale.Total Losing Trade') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Report Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="card card-transaction">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.Trade Contracts') }}</h4>
                            {{-- <div class="dropdown chart-dropdown">
                                <i class="bi bi-three-dots-vertical font-medium-3 cursor-pointer"
                                    data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body" style="max-height:280px;overflow-y:auto;">
                            @forelse($tradelogs as $tradelog)
                                <div class="transaction-item">
                                    <div class="d-flex">
                                        <div class="avatar bg-light-primary rounded float-start">
                                            <div class="avatar-content">
                                                @if($tradelog->hilow == 1)
                                                <span class="text-success font-medium-5"><i class="bi bi-graph-up-arrow"></i></span>
                                                @elseif($tradelog->hilow == 2)
                                                <span class="text-danger font-medium-5"><i
                                                        class="bi bi-graph-down-arrow"></i></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <h6 class="transaction-title">
                                                @if($tradelog->hilow == 1)
                                                <span class="text-success">{{ __('locale.Rise')}}</span>
                                                @elseif($tradelog->hilow == 2)
                                                <span class="text-danger">{{ __('locale.Fall')}}</span>
                                                @endif
                                            </h6>
                                            <small>{{__($tradelog->symbol)}} / {{__($tradelog->pair)}}</small>
                                        </div>

                                    </div>
                                    <div class="fw-bolder">
                                        @if($tradelog->result == 1)
                                        <span class="badge bg-success">+ {{getAmount($tradelog->amount * ($gnl->profit / 100))}}
                                            {{$tradelog->pair}}</span>
                                        @elseif($tradelog->result == 2)
                                        <span class="badge bg-danger">- {{getAmount($tradelog->amount)}}
                                            {{$tradelog->pair}}</span>
                                        @elseif($tradelog->result == 3)
                                        <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
                                        @else
                                        <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                            <div colspan="100%"> {{ __('locale.No results found')}}!</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($platform->kyc->kyc_status == 1)
                    @include('user/partials/kyc')
                @endif
            </div>
        </section>
    </div>

    <div class="modal fade custom--modal" id="practiceAmount">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('locale.Add Practice Balance')}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <form class="deposit-form" action="{{route('user.binary.add.practice.balance')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure you want to add practice balance')}}?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm text--white btn-danger"
                            data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit"
                            class="btn btn-primary btn-sm text--white btn-success">{{ __('locale.Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
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

        var $tradePositive = {{ $trade['Win'] }} - {{ $trade['Lose'] }};
        var $totaltrades = {{ $trade['Win'] }} + {{ $trade['Lose'] }} + {{ $trade['Draw'] }} ;
        var $tradePositive = (typeof $tradePositive === 'undefined') ? '0' : $tradePositive;

        var $practice_Positive = {{ $trade['practice_Win'] }} - {{ $trade['practice_Lose'] }};
        var $practice_totaltrades = {{ $trade['practice_Win'] }} + {{ $trade['practice_Lose'] }} + {{ $trade['practice_Draw'] }} ;
        var $practice_Positive = (typeof $practice_Positive === 'undefined') ? '0' : $practice_Positive;
        $(window).on('load', async function () {
        'use strict';

        var $barColor = '#f3f3f3';
        var $trackBgColor = '#EBEBEB';
        var $textMutedColor = '#b9b9c3';
        var $budgetStrokeColor2 = '#dcdae3';
        var $goalStrokeColor2 = '#51e5a8';
        var $strokeColor = '#ebe9f1';
        var $textHeadingColor = '#5e5873';
        var $earningsStrokeColor2 = '#28c76f66';
        var $earningsStrokeColor3 = '#28c76f33';

        var $earningsChart = document.querySelector('#earnings-chart');
        var earningsChartOptions;
        var earningsChart;

        var $practice_earningsChart = document.querySelector('#practice_earnings-chart');
        var practice_earningsChartOptions;
        var practice_earningsChart;

        var isRtl = $('html').attr('data-textdirection') === 'rtl';

        //--------------- Earnings Chart ---------------
        //----------------------------------------------
        earningsChartOptions = {
            chart: {
            type: 'donut',
            height: 120,
            toolbar: {
                show: false
            }
            },
            dataLabels: {
            enabled: false
            },
            series: [{{ $trade['Win'] }}, {{ $trade['Draw'] }}, {{ $trade['Lose'] }}],
            legend: { show: false },
            comparedResult: [2, -3, 8],
            labels: ['Wins', 'Draws', 'Loses'],
            stroke: { width: 0 },
            colors: [window.colors.solid.success, $earningsStrokeColor3, '#EA5455'],
            grid: {
            padding: {
                right: -20,
                bottom: -8,
                left: -20
            }
            },
            plotOptions: {
            pie: {
                startAngle: -10,
                donut: {
                labels: {
                    show: true,
                    name: {
                    offsetY: 15
                    },
                    value: {
                    offsetY: -15,
                    formatter: function (val) {
                        return parseFloat((val / $totaltrades) * 100).toFixed(1) + '%';
                    }
                    },
                    total: {
                    show: true,
                    offsetY: 15,
                    label: 'Positive',
                    formatter: function (w) {
                        return $tradePositive;
                    }
                    }
                }
                }
            }
            },
            responsive: [
            {
                breakpoint: 1325,
                options: {
                chart: {
                    height: 100
                }
                }
            },
            {
                breakpoint: 1200,
                options: {
                chart: {
                    height: 120
                }
                }
            },
            {
                breakpoint: 1045,
                options: {
                chart: {
                    height: 100
                }
                }
            },
            {
                breakpoint: 992,
                options: {
                chart: {
                    height: 120
                }
                }
            }
            ]
        };
        earningsChart = new ApexCharts($earningsChart, earningsChartOptions);
        earningsChart.render();
        //--------------- Earnings Chart ---------------
        //----------------------------------------------
        practice_earningsChartOptions = {
            chart: {
            type: 'donut',
            height: 120,
            toolbar: {
                show: false
            }
            },
            dataLabels: {
            enabled: false
            },
            series: [{{ $trade['practice_Win'] }}, {{ $trade['practice_Draw'] }}, {{ $trade['practice_Lose'] }}],
            legend: { show: false },
            comparedResult: [2, -3, 8],
            labels: ['Wins', 'Draws', 'Loses'],
            stroke: { width: 0 },
            colors: [window.colors.solid.success, $earningsStrokeColor3, '#EA5455'],
            grid: {
            padding: {
                right: -20,
                bottom: -8,
                left: -20
            }
            },
            plotOptions: {
            pie: {
                startAngle: -10,
                donut: {
                labels: {
                    show: true,
                    name: {
                    offsetY: 15
                    },
                    value: {
                    offsetY: -15,
                    formatter: function (val) {
                        return parseFloat((val / $practice_totaltrades) * 100).toFixed(1) + '%';
                    }
                    },
                    total: {
                    show: true,
                    offsetY: 15,
                    label: 'Positive',
                    formatter: function (w) {
                        return $practice_Positive;
                    }
                    }
                }
                }
            }
            },
            responsive: [
            {
                breakpoint: 1325,
                options: {
                chart: {
                    height: 100
                }
                }
            },
            {
                breakpoint: 1200,
                options: {
                chart: {
                    height: 120
                }
                }
            },
            {
                breakpoint: 1045,
                options: {
                chart: {
                    height: 100
                }
                }
            },
            {
                breakpoint: 992,
                options: {
                chart: {
                    height: 120
                }
                }
            }
            ]
        };
        practice_earningsChart = new ApexCharts($practice_earningsChart, practice_earningsChartOptions);
        practice_earningsChart.render();
});
    </script>
@endpush
