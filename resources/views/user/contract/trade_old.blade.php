@extends('layouts.app')
@php
use \mobiledetect\mobiledetectlib\Detection;
$detect = new Mobile_Detect;
@endphp
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.css">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css'))}}">
    @if( $detect->isMobile() && !$detect->isTablet() )
        <style>
            @media
            only screen
            and (min-device-width               : 1px)
            and (max-device-width               : 897px)
            and (orientation                    : landscape) {
            .responsive-portrait {
                display : flex!important;
            }
            body > footer { display: none; }
            div.ads {
                display: none;
            }
            }
        </style>
    @endif
@endsection
@section('content')
<div class="se-pre-con">
    <div class="se-pre-con2 spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>

@if( $detect->isMobile() && !$detect->isTablet() )
<div class="responsive-portrait ov-nblr">
    <div>
        <div class="brand-text"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}"
                alt="{{ __('locale.image')}}"></div>
        <span>Please turn your device in portrait mode.</span>
    </div>
</div>
<div class="row" style="margin-right:5px;">
    <div id="appM"></div>
</div>
<div class="position-absolute bottom-0 mb-1 w-100">
    <form id="playGame">
        <div class="card mb-1 mx-1">
            <div class="row justify-content-between align-items-center mb-1">
                <div class="col text-center">
                    <div type="button" class="btn fs-6 btn-sm btn-outline-info my-1" id="amount">{{ $pair }}</div>
                    <div class="input-group ps-1 w-auto">
                        <input type="number" class="form-control" min="{{ $limits->min_amount }}" max="{{ $limits->max_amount }}" step="{{ $limits->min_amount }}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="" id="amount" name="amount" placeholder="Amount">
                    </div>
                </div>
                <div class="col text-center">
                    <div class="highlight m-1" role="group">
                        <button class="btn btn-outline-warning dropdown-toggle btn-sm" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="timed">---</button>
                            <ul class="dropdown-menu dropdown-menu-end" id="timer">
                              <li><a id="sec" name="sec" value="sec" min="{{ $limits->min_time_sec }}" max="{{ $limits->max_time_sec }}" href="javascript:void(0)" class="btn-sm dropdown-item" href="#">Sec</a></li>
                              <li><a id="min" name="min" value="min" min="{{ $limits->min_time_min }}" max="{{ $limits->max_time_min }}" href="javascript:void(0)" class="btn-sm dropdown-item" href="#">Min</a></li>
                              <li><a id="hour" name="hour" value="hour" min="{{ $limits->min_time_hour }}" max="{{ $limits->max_time_hour }}" href="javascript:void(0)" class="btn-sm dropdown-item" href="#">Hour</a></li>
                            </ul>
                    </div>
                    <div class="w-100 pe-1">
                        <input type="number" class="form-control" min="{{ $limits->min_time_sec }}"
                            max="{{ $limits->max_time_sec }}" required="" id="gametimesec" name="gametimesec" placeholder="Time">
                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex justify-content-center align-items-center mx-1">
            <button class="col-6 d-flex justify-content-between align-items-center w-50 btn btn-success highlowButton"
                type="submit" name="highlow" value="1">
                <div class="text-start">Rise</div>
                <div class="text-end"> {{ number_format($gnl->profit) }}%</div>
            </button>
            <button
                class="col-6 d-flex justify-content-between align-items-center w-50 ms-1 btn btn-danger highlowButton"
                type="submit" name="highlow" value="2">
                <div class="text-start">Fall</div>
                <div class="text-end"> {{ number_format($gnl->profit) }}%</div>
            </button>
        </div>
    </form>
</div>
@else
<div class="row" style="margin-right:5px;">
    <div id="app"></div>
    <div class="flex-end col-2 col-xll-2 col-xl-2 col-lg-2 col-md-3 col-sm-6">
        <div class="mt-5">
            <div class="card mb-1">
                @if($wallet == null)
                    <div class="text-center my-1">
                        <form method="POST" action="{{ route('user.wallet.create') }}">
                            @csrf
                            <input type="hidden" id="symbol" name="symbol" value="{{ $pair }}">
                            <input type="hidden" id="type" name="type" value="funding">
                            <button type="submit" class="btn btn-success btn-sm">Create Wallet</button></span>
                        </form>
                    </div>
                @else
                {{-- <div class="btn-group dropstart"> --}}
                <button id="TType" type="button" class="btn btn-primary  mx-1 my-1">Rise / Fall</button>
                {{--  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" value="rf"
                        <div id="Tdrop" class="dropdown-menu">
                        <a class="dropdown-item" value="rf">Rise / Fall</a>
                        <a class="dropdown-item" value="oe">Odd / Even</a>
                    </div>
                </div> --}}
                @endif
            </div>
            <div class="card mb-1">
                <form id="playGame" class="mt-1 text-center">
                    <div class="predict-group">
                        <div class="input-group mb-1 mx-1 w-auto highlight">
                            <input type="number" class="form-control" min="{{ $limits->min_time_sec }}"
                            max="{{ $limits->max_time_sec }}" required="" id="gametimesec" name="gametimesec" placeholder="Time">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="timed">Sec</button>
                            <ul class="dropdown-menu dropdown-menu-end" id="timer">
                              <li><a id="sec" name="sec" value="sec" min="{{ $limits->min_time_sec }}" max="{{ $limits->max_time_sec }}" href="javascript:void(0)" class="dropdown-item" href="#">Sec</a></li>
                              <li><a id="min" name="min" value="min" min="{{ $limits->min_time_min }}" max="{{ $limits->max_time_min }}" href="javascript:void(0)" class="dropdown-item" href="#">Min</a></li>
                              <li><a id="hour" name="hour" value="hour" min="{{ $limits->min_time_hour }}" max="{{ $limits->max_time_hour }}" href="javascript:void(0)" class="dropdown-item" href="#">Hour</a></li>
                            </ul>
                        </div>
                        @if($wallet != 'null')
                        <div class="input-group mb-1 mx-1 w-auto">
                            <input type="number" class="form-control" min="{{ $limits->min_amount }}" max="{{ $limits->max_amount }}" step="{{ $limits->min_amount }}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="" id="amount" name="amount" placeholder="Amount">
                            <span class="input-group-text text-light" id="amount">{{ $pair }}</span>
                        </div>
                        @endif

                        <div class="highlow-predict mx-1">
                            <button
                                class="col d-flex justify-content-between align-items-center w-100 btn btn-success highlowButton"
                                type="submit" name="highlow" value="1">
                                <div class="text-start"><i class="bi bi-graph-up-arrow fs-3"
                                        style="margin-bottom:3px;"></i> Rise</div>
                                <div class="text-end"> {{ number_format($gnl->profit) }}%</div>
                            </button>
                            <button
                                class="col d-flex justify-content-between align-items-center w-100  my-1 btn btn-danger highlowButton"
                                type="submit" name="highlow" value="2">
                                <div class="text-start"><i class="bi bi-graph-down-arrow fs-3"
                                        style="margin-bottom:3px;"></i> Fall</div>
                                <div class="text-end"> {{ number_format($gnl->profit) }}%</div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="btn btn-secondary w-auto m-1" data-bs-toggle="modal"
                data-bs-target="#schedule"><i class="bi bi-alarm"></i> Schedule Order</div>
            </div>
            <div class="text-center" id="open_contract">
            </div>
        </div>
    </div>
</div>
@endif
<div class="modal modal-slide-in fade" id="schedule">
    <div class="modal-dialog sidebar-sm">
      <form class="add-new-record modal-content pt-0" action="{{route('user.binary.trade.schedule')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
        <div class="modal-header mb-1">
          <h5 class="modal-title" id="send1">{{ __('locale.Schedule Order') }}</h5>
        </div>
        <div class="modal-body flex-grow-1">
            <input type="hidden" name="market" value="{{ $symbol }}">
            <input type="hidden" name="pair" value="{{ $pair }}">
            <input type="hidden" name="type">
            <input type="hidden" name="unit" value="sec">
            <input type="hidden" name="account" value="2">
            <input type="hidden" name="current" value="{{ getCoinRate($symbol) }}">
            <label class="form-label" for="timedd">{{ __('locale.Order Duration')}}</label>
            <div class="input-group mb-1">
                <input type="number" class="form-control" min="{{ $limits->min_time_sec }}"
                max="{{ $limits->max_time_sec }}" required="" id="duration" name="duration" placeholder="Time">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" id="timedd">Sec</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a min="{{ $limits->min_time_sec }}" max="{{ $limits->max_time_sec }}" class="dropdown-item"
                    onclick="$('#timedd').text($(this).text()); $('#schedule').find('input[name=unit]').val($(this).data('unit'));
                    $('#duration').attr('min',$(this).attr('min')); $('#duration').attr('max',$(this).attr('max'));"
                    data-unit="sec">Sec</a></li>
                  <li><a min="{{ $limits->min_time_min }}" max="{{ $limits->max_time_min }}" class="dropdown-item"
                    onclick="$('#timedd').text($(this).text()); $('#schedule').find('input[name=unit]').val($(this).data('unit'));
                    $('#duration').attr('min',$(this).attr('min')); $('#duration').attr('max',$(this).attr('max'));"
                    data-unit="min">Min</a></li>
                  <li><a min="{{ $limits->min_time_hour }}" max="{{ $limits->max_time_hour }}" class="dropdown-item"
                    onclick="$('#timedd').text($(this).text()); $('#schedule').find('input[name=unit]').val($(this).data('unit'));
                    $('#duration').attr('min',$(this).attr('min')); $('#duration').attr('max',$(this).attr('max'));"
                    data-unit="hour">Hour</a></li>
                </ul>
            </div>
            @if($wallet != 'null')
                <label class="form-label" for="amount">{{ __('locale.Order Amount')}}</label>
                <div class="input-group mb-1">
                    <input type="number" class="form-control" min="{{ $limits->min_amount }}" max="{{ $limits->max_amount }}" step="{{ $limits->min_amount }}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" required="" id="amount" name="amount" placeholder="Amount">
                    <span class="input-group-text text-light" id="amount">{{ $pair }}</span>
                </div>
            @endif
            <label class="form-label" for="typed">{{ __('locale.Order Type')}}</label>
            <div class="input-group mb-1">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" id="typed">Select Order Type</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item text-success" onclick="$('#typed').text($(this).text());
                    $('#schedule').find('input[name=type]').val($(this).data('type'));
                    $('#typed').removeClass('btn-outline-secondary');$('#typed').removeClass('btn-danger');
                    $('#typed').addClass('btn-success');" data-type="1">Rise</a></li>
                  <li><a class="dropdown-item text-danger" onclick="$('#typed').text($(this).text());
                    $('#schedule').find('input[name=type]').val($(this).data('type'));
                    $('#typed').removeClass('btn-outline-secondary');$('#typed').removeClass('btn-succes');
                    $('#typed').addClass('btn-danger');" data-type="2">Fall</a></li>
                </ul>
            </div>
            <label class="form-label" for="price">{{ __('locale.Price where the order will be placed')}}</label>
            <div class="input-group mb-1">
                <input type="text" class="form-control price" id="price" maxlength="30" name="price" value="{{ ttz(getCoinRate($symbol)) }}" placeholder="{{ __('locale.Order When Price = ..')}}" required>
                <span class="input-group-text text-light">{{ $pair }}</span>
            </div>
            <button type="submit" class="btn btn-primary me-1">{{ __('locale.Order')}}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('locale.Cancel')}}</button>
        </div>
      </form>
    </div>
  </div>
<div class="modal fade" id="plotly" tabindex="-1" aria-labelledby="plotly" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3 px-sm-3">
                <div class="nav-vertical vertical wizard-modern create-app-wizard">
                    <div class="row d-flex justify-content-center mb-1">
                        <div class="row mb-1">
                            <div class="col">
                                <h5 class="card-title">1 <span class="text-info">{{$symbol}}</span>
                                    =
                                    <span class="text-warning" id="cryptoPrice"></span> <span>{{ $pair }}
                                        </p>
                                </h5>
                            </div>
                            <div class="col">
                                <span class="trade-user-price"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="clock"></div>
                        </div>
                    </div>
                    <div id="graph" style="transform: scale(0.8);"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
    @if( $detect->isMobile() && !$detect->isTablet() )
        <script src="{{ asset(mix('js/mainM.js')) }}"></script>
    @else
        <script src="{{ asset(mix('js/main.js')) }}"></script>
    @endif
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plotly.js/1.33.1/plotly-basic.min.js"></script>
        <script src="{{ asset(mix('/vendors/js/amcharts/index.js')) }}"></script>
        <script src="{{ asset(mix('/vendors/js/amcharts/xy.js')) }}"></script>
        <script src="{{ asset(mix('/vendors/js/amcharts/Animated.js')) }}"></script>
        <script src="{{ asset(mix('/vendors/js/amcharts/Dark.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js'))}}"></script>
    @endsection
@push('script')
    <script>
        "use strict";
        window.onload = prepareButton;
        let ws_i = new WebSocket('wss://stream.binance.com:9443/ws');
        async function prepareButton() {
            $(".se-pre-con").fadeOut("slow");
            var timesClicked = 0;
            if (ws_i.readyState == WebSocket.OPEN) {
                ws_i.send(JSON.stringify({
                    'method': 'UNSUBSCRIBE',
                    'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth10@100ms'],
                    'id': 1
                }))
                ws_i.send(JSON.stringify({
                    'method': 'UNSUBSCRIBE',
                    'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth20@100ms'],
                    'id': 2
                }))
                ws_i.send(JSON.stringify({
                    'method': 'UNSUBSCRIBE',
                    'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@ticker'],
                    'id': 3
                }))
                ws_i.send(JSON.stringify({
                    'method': 'UNSUBSCRIBE',
                    'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@miniTicker'],
                    'id': 4
                }))
            }
            document.getElementById('toggleInfo').onclick = function () {
                timesClicked++;
                if (timesClicked%2 == 0) {
                    ws_i.send(JSON.stringify({
                        'method': 'UNSUBSCRIBE',
                        'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@ticker'],
                        'id': 3
                    }))
                } else {
                    /* Binance */
                    let el_b = document.getElementById('show_b');
                    let last_b = null;
                    let el_P = document.getElementById('show_P');
                    let el_p = document.getElementById('show_p');
                    let slider = document.getElementById("myRange");
                    let sliderColor = document.getElementById("myRangeColor");
                    let el_l = document.getElementById('show_l');
                    let el_h = document.getElementById('show_h');
                    let min = document.getElementById("myRange").getAttribute('aria-valuemin');
                    let max = document.getElementById("myRange").getAttribute('aria-valuemax');
                    let now = document.getElementById("myRange").getAttribute('aria-valuenow');
                    let el_v = document.getElementById('show_v');
                    let el_mc = document.getElementById('show_mc');
                    let el_ts = document.getElementById('show_ts');
                    ws_i.send(JSON.stringify({
                        'method': 'SUBSCRIBE',
                        'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@ticker'],
                        'id': 3
                    }))
                    ws_i.onmessage = function (event1) {
                        let data = JSON.parse(event1.data);
                        let b = parseFloat(data.b).toFixed(2);
                        let P = parseFloat(data.P).toFixed(2);
                        let p = parseFloat(data.p).toFixed(2);
                        let o = parseFloat(data.o).toFixed(2);
                        let h = parseFloat(data.h).toFixed(2);
                        let l = parseFloat(data.l).toFixed(2);
                        let v = parseFloat(data.v).toFixed(2);
                        let q = parseFloat(data.q).toFixed(2);
                        let c = parseFloat(data.c).toFixed(2);
                        el_b.innerText = b;
                        if (b < last_b) {
                            el_b.innerHTML = b + '<i class="bi bi-arrow-down"></i>';
                            el_b.style.color = 'rgb(246,70,93';
                        } else if (b > last_b) {
                            el_b.innerHTML = b + '<i class="bi bi-arrow-up"></i>';
                            el_b.style.color = 'rgb(14,203,129)';
                        } else {
                            el_b.innerText = b;
                            el_b.style.color = 'dark';
                        }
                        last_b = b;
                        el_P.innerText = P;
                        el_p.innerText = p;
                        if (P < 0) {
                            el_P.innerHTML = '<i class="bi bi-arrow-down"></i>' + P + '%';
                            el_P.style.color = 'rgb(246,70,93';
                        } else if (P > 0) {
                            el_P.innerHTML = '<i class="bi bi-arrow-up"></i>' + P + '%';
                            el_P.style.color = 'rgb(14,203,129)';
                        } else {
                            el_P.innerHTML = '(' + P + ')';
                            el_P.style.color = 'dark';
                        }
                        el_p.innerText = p;

                        if (p < 0) {
                            el_p.innerText = p;
                            el_p.style.color = 'rgb(246,70,93';
                        } else if (p > 0) {
                            el_p.innerText = p;
                            el_p.style.color = 'rgb(14,203,129)';
                        } else {
                            el_p.innerText = p;
                            el_p.style.color = 'dark';
                        }
                        el_l.innerText = l;
                        el_h.innerText = h;
                        min = l;
                        max = h;
                        now = b;
                        let siz = 100 * ((now - min) / (max - min));
                        slider.style = 'width: ' + siz + '%';
                        if (siz > 66) {
                            sliderColor.classList.add('progress-bar-success')
                            sliderColor.classList.remove('progress-bar-warning')
                            sliderColor.classList.remove('progress-bar-danger')
                        } else if (siz > 33 && siz < 66) {
                            sliderColor.classList.add('progress-bar-warning')
                            sliderColor.classList.remove('progress-bar-success')
                            sliderColor.classList.remove('progress-bar-danger')
                        } else if (siz < 33) {
                            sliderColor.classList.add('progress-bar-danger')
                            sliderColor.classList.remove('progress-bar-success')
                            sliderColor.classList.remove('progress-bar-warning')
                        }
                        el_v.innerText = v;
                        let mc = ((q * c) / 100000000000).toFixed(2);
                        let ts = (q / 100000000).toFixed(2);
                        el_mc.innerText = mc + 'B';
                        el_ts.innerText = ts + 'M';
                    };
                }
            }
            document.getElementById('toggleDepth').onclick = function () {
                timesClicked++;
                if (timesClicked%2 == 0) {
                    ws_i.send(JSON.stringify({
                            'method': 'UNSUBSCRIBE',
                            'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth20@100ms'],
                            'id': 2
                        }))
                    } else {
                        ws_i.send(JSON.stringify({
                                'method': 'SUBSCRIBE',
                                'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth20@100ms'],
                                'id': 2
                            }))
                am5.ready(function () {
                    var root = am5.Root.new("chartdiv");
                    root.setThemes([
                        am5themes_Animated.new(root),
                        am5themes_Dark.new(root),
                    ]);
                    var chart = root.container.children.push(
                        am5xy.XYChart.new(root, {
                            focusable: true,
                            panX: false,
                            panY: false,
                            wheelX: "none",
                            wheelY: "none"
                        })
                    );

                    /*var title = chart.plotContainer.children.push(am5.Label.new(root, {
                        text: "Price (BTC/ETH)",
                        fontSize: 20,
                        fontWeight: "400",
                        x: am5.p50,
                        centerX: am5.p50
                    }))*/

                    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                        categoryField: "value",
                        renderer: am5xy.AxisRendererX.new(root, {
                            minGridDistance: 70
                        }),
                        tooltip: am5.Tooltip.new(root, {})
                    }));

                    xAxis.get("renderer").labels.template.adapters.add("text", function (text, target) {
                        if (target.dataItem) {
                            return root.numberFormatter.format(Number(target.dataItem.get("category")), "#.####");
                        }
                        return text;
                    });

                    var yAxis = chart.yAxes.push(
                        am5xy.ValueAxis.new(root, {
                            maxDeviation: 0.1,
                            renderer: am5xy.AxisRendererY.new(root, {})
                        })
                    );

                    var bidsTotalVolume = chart.series.push(am5xy.StepLineSeries.new(root, {
                        minBulletDistance: 10,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "bidstotalvolume",
                        categoryXField: "value",
                        stroke: am5.color(0x00ff00),
                        fill: am5.color(0x00ff00),
                        tooltip: am5.Tooltip.new(root, {
                            pointerOrientation: "horizontal",
                            labelText: "[width: 120px]Ask:[/][bold]{categoryX}[/]\n[width: 120px]Total volume:[/][bold]{valueY}[/]\n[width: 120px]Volume:[/][bold]{bidsvolume}[/]"
                        })
                    }));
                    bidsTotalVolume.strokes.template.set("strokeWidth", 2)
                    bidsTotalVolume.fills.template.setAll({
                        visible: true,
                        fillOpacity: 0.2
                    });

                    var asksTotalVolume = chart.series.push(am5xy.StepLineSeries.new(root, {
                        minBulletDistance: 10,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "askstotalvolume",
                        categoryXField: "value",
                        stroke: am5.color(0xf00f00),
                        fill: am5.color(0xff0000),
                        tooltip: am5.Tooltip.new(root, {
                            pointerOrientation: "horizontal",
                            labelText: "[width: 120px]Ask:[/][bold]{categoryX}[/]\n[width: 120px]Total volume:[/][bold]{valueY}[/]\n[width: 120px]Volume:[/][bold]{asksvolume}[/]"
                        })
                    }));
                    asksTotalVolume.strokes.template.set("strokeWidth", 2)
                    asksTotalVolume.fills.template.setAll({
                        visible: true,
                        fillOpacity: 0.2
                    });

                    var bidVolume = chart.series.push(am5xy.ColumnSeries.new(root, {
                        minBulletDistance: 10,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "bidsvolume",
                        categoryXField: "value",
                        fill: am5.color(0x000000)
                    }));
                    bidVolume.columns.template.set("fillOpacity", 0.2);

                    var asksVolume = chart.series.push(am5xy.ColumnSeries.new(root, {
                        minBulletDistance: 10,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "asksvolume",
                        categoryXField: "value",
                        fill: am5.color(0x000000)
                    }));
                    asksVolume.columns.template.set("fillOpacity", 0.2);

                    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                        xAxis: xAxis
                    }));
                    cursor.lineY.set("visible", false);

                        function loadData() {
                            ws_i.onmessage = function (event2) {
                                var data = JSON.parse(event2.data);
                                var res = [];
                                processData(data.bids, "bids", true, res);
                                processData(data.asks, "asks", false, res);
                                xAxis.data.setAll(res);
                                bidsTotalVolume.data.setAll(res);
                                asksTotalVolume.data.setAll(res);
                                bidVolume.data.setAll(res);
                                asksVolume.data.setAll(res);
                            };
                        }

                        loadData();

                        function processData(list, type, desc, res) {

                            for (var i = 0; i < list.length; i++) {
                                list[i] = {
                                    value: Number(list[i][0]),
                                    volume: Number(list[i][1]),
                                }
                            }

                            list.sort(function (a, b) {
                                if (a.value > b.value) {
                                    return 1;
                                } else if (a.value < b.value) {
                                    return -1;
                                } else {
                                    return 0;
                                }
                            });

                            if (desc) {
                                for (var i = list.length - 1; i >= 0; i--) {
                                    if (i < (list.length - 1)) {
                                        list[i].totalvolume = list[i + 1].totalvolume + list[i].volume;
                                    } else {
                                        list[i].totalvolume = list[i].volume;
                                    }
                                    var dp = {};
                                    dp["value"] = list[i].value;
                                    dp[type + "volume"] = list[i].volume;
                                    dp[type + "totalvolume"] = list[i].totalvolume;
                                    res.unshift(dp);
                                }
                            } else {
                                for (var i = 0; i < list.length; i++) {
                                    if (i > 0) {
                                        list[i].totalvolume = list[i - 1].totalvolume + list[i].volume;
                                    } else {
                                        list[i].totalvolume = list[i].volume;
                                    }
                                    var dp = {};
                                    dp["value"] = list[i].value;
                                    dp[type + "volume"] = list[i].volume;
                                    dp[type + "totalvolume"] = list[i].totalvolume;
                                    res.push(dp);
                                }
                            }
                        }

                });
            }

            }
            document.getElementById('toggleOrders').onclick = function () {
                timesClicked++;
                if (timesClicked%2 == 0) {
                    ws_i.send(JSON.stringify({
                        'method': 'UNSUBSCRIBE',
                        'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth10@100ms'],
                        'id': 1
                    }))
                } else {
                    var computBarWidth = {
                        width: 250,
                        sortDepth: {
                            sort: function (e) {
                                return e.sort(function (e, t) {
                                    return e[1] - t[1]
                                }), e
                            },
                            median: function (e) {
                                var t = Math.floor(e.length / 3 * 2);
                                return e[t][1] < 1 ? 1 : e[t][1]
                            },
                            medianUnit: function (e, t, n) {
                                var r = new Array(e);
                                r = r[0];
                                var o = new Array(t);
                                o = o[0], r = r.concat(o);
                                var i = this.median(this.sort(r)) / n;
                                return o = r = null, i
                            },
                            width: function (e, t) {
                                if (0 == t) return 1;
                                var n = Math.round(Number(e) / t);
                                return n <= 0 ? 1 : 160 < n ? 160 : n
                            }
                        },
                        init: function (e, t) {
                            var n = [],
                                r = [];
                            e.forEach(function (e) {
                                n.push(e);
                            }), t.forEach(function (e) {
                                r.push(e)
                            });
                            var o = this.sortDepth.medianUnit(n, r, 48);
                            e.forEach(function (e) {
                                e.push({
                                    width: computBarWidth.sortDepth.width(e[1], o) * computBarWidth.width / 100
                                })
                            }), t.forEach(function (e) {
                                e.push({
                                    width: computBarWidth.sortDepth.width(e[1], o) * computBarWidth.width / 100
                                })
                            })
                        }
                    }

                    function number_format(number, decimals, decPoint, thousandsSep) {
                        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
                        var n = !isFinite(+number) ? 0 : +number
                        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
                        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
                        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
                        var s = ''

                        var toFixedFix = function (n, prec) {
                            var k = Math.pow(10, prec)
                            return '' + (Math.round(n * k) / k)
                                .toFixed(prec)
                        }

                        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
                        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
                        if (s[0].length > 3) {
                            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
                        }
                        if ((s[1] || '').length < prec) {
                            s[1] = s[1] || ''
                            s[1] += new Array(prec - s[1].length + 1).join('0')
                        }

                        return s.join(dec)
                    }
                    ws_i.send(JSON.stringify({
                        'method': 'SUBSCRIBE',
                        'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@depth10@100ms'],
                        'id': 1
                    }))
                    ws_i.onmessage = function (event3) {
                        let data = JSON.parse(event3.data);

                        computBarWidth.init(data.bids, data.asks);

                        $('.asks,.bids').empty();

                        $.each(data.asks, function (index, item) {
                            let row = $('<tr>')
                                .append($('<td>').css("color", "rgb(246,70,93)").addClass("price").append($("<span>").text(Number(item[0]).toFixed(2))))
                                .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1]).toFixed(6))))
                                .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[0] * item[1]), 2, ",")))
                                    .append($("<div>").addClass("percent").css("width", item[2].width + "px")));

                            if (index > 10) row.hide();

                            $('.asks').prepend(row);
                        });
                        $.each(data.bids, function (index, item) {
                            let row = $('<tr>')
                                .append($('<td>').css("color", "rgb(14,203,129)").addClass("price").append($("<span>").text(Number(item[0]).toFixed(2))))
                                .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1]).toFixed(6))))
                                .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[0] * item[1]), 2, ",")))
                                    .append($("<div>").addClass("percent").css("width", item[2].width + "px")));

                            if (index > 10) row.hide();

                            $('.bids').prepend(row);
                        });
                    }
                }
            }
        }

        $(document).ready(function () {
            var obj = [];
            var json = JSON.stringify(obj);
            var tradeLogId;
            var playTime;
            var playTimeUnit;
            var second;
            var highlowType;
            var pair = "{{ $pair }}";
            var symbol = "{{$symbol}}";
            const highLowArray = [1, 2];
            @if ($wallet != null)
                const userBalance = {{  $wallet->balance  }};
            @else
                const userBalance = 0;
            @endif

            $(document).on('keyup mouseup change', '#gametimesec', function () {
                playTime = document.getElementById("gametimesec").value;
            });
            $("#timer").on('click', 'li a', function () {
                $("#timed").text($(this).text());
                $("#gametimesec").attr('min',$(this).attr('min'));
                $("#gametimesec").attr('max',$(this).attr('max'));
                playTimeUnit = $("#timed").text();
            });
            $(window ).on('load', function () {
                playTimeUnit = $("#timed").text();
            });

            $(".highlowButton").on('click', function () {
                highlowType = $(this).val();
            })

            $("#playGame").on('submit', function (event4) {
                event4.preventDefault();
                var amount = $('input[name="amount"]').val();
                var timeCount = secondCount();

                if (!highLowArray.includes(parseInt(highlowType))) {
                    notify('error', 'Invalid Game Type');
                } else if (userBalance < amount) {
                    notify('error', 'Your Balance Not Enough! Please Add Balance First');
                } else if (isNaN(amount) || amount <= 0) {
                    notify('error', 'Please Insert Valid Amount')
                } else if (isNaN(timeCount) || timeCount <= 0) {
                    notify('error', 'Please Select Valid Time')
                } else {
                    $('#plotly').modal('show');
                    var arrayLength = playTime + 2;
                    var newArray = [];
                    var xArray = [];
                    var timezone;
                    var gtime;
                    var coinSymbol = "{{$symbol}}";

                    for (var i = 0; i < arrayLength; i++) {
                        var y;
                        var x;
                        newArray[i] = y
                        xArray[i] = x
                    }
                    var baseColor = "#{{ $general->base_color }}"
                    var trace1 = {
                        x: xArray,
                        y: newArray,
                        showlegend: true,
                        line: {
                            color: baseColor
                        },
                        visible: true,
                        xaxis: 'x1',
                        yaxis: 'y1',
                    };
                    var data = [trace1];
                    var layout = {
                        xaxis: {
                            tickfont: {
                                size: 14,
                                color: '#fff'
                            },
                            ticklen: 8,
                            tickwidth: 2,
                            tickcolor: '#8f2331'
                        },
                        yaxis: {
                            tickfont: {
                                size: 14,
                                color: '#fff'
                            },
                            ticklen: 8,
                            tickwidth: 2,
                            tickcolor: '#8f2331'
                        },
                        paper_bgcolor: '#141c24',
                        plot_bgcolor: '#141c24',
                        showlegend: false,
                    };
                    Plotly.newPlot('graph', {
                        data: data,
                        layout: layout
                    });
                    ws_i.send(JSON.stringify({
                            'method': 'SUBSCRIBE',
                            'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@miniTicker'],
                            'id': 4
                        }))
                    var inter = setInterval(function () {
                        var dateTime = new Date();
                        timezone = dateTime.getTimezoneOffset() / 60;
                        gtime = dateTime.getHours() + ':' + dateTime.getMinutes() + ':' + dateTime.getSeconds();
                        var time = dateTime.getHours() + ':' + dateTime.getMinutes() + ':' + dateTime.getSeconds();
                        ws_i.onmessage = function (eventX) {
                            let data = JSON.parse(eventX.data);
                            let o = parseFloat(data.c);
                            let E = parseFloat(data.E);
                            $('#cryptoPrice').text(o);
                            var y = o;
                            var x = time;
                            newArray = newArray.concat(y)
                            newArray.splice(0, 1)
                            xArray = xArray.concat(x)
                            xArray.splice(0, 1)
                            obj.push({time: E, value:o});
                        };
                        var data_update = {
                            x: [xArray],
                            y: [newArray]
                        };

                        Plotly.update('graph', data_update)
                    }, 1000);
                    $('input[name="amount"]').val("");
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('user.binary.trade.store') }}",
                        method: "POST",
                        data: {
                            amount: amount,
                            symbol: symbol,
                            highlowType: highlowType,
                            duration: playTime,
                            pair: pair,
                            unit: playTimeUnit
                        },
                        success: function (response) {
                            if (response.value == 1) {
                                tradeLogId = response.tradeLogId;
                                countDown(timeCount, tradeLogId)

                                if (highlowType == 1) {

                                    $(".trade-user-price").text("You Trade: Rise. Price Was " + response.trade + " " + "USD");
                                    $("#open_contract").append($( `<button type="button" class="btn btn-info" onClick="$('#plotly').modal('show');">View Open Contract</button>` ));

                                    notify('success', 'Trade: Rise');
                                } else {

                                    $(".trade-user-price").text("You Trade: Fall. Price Was " + response.trade + " " + "USD");
                                    $("#open_contract").append($( `<button type="button" class="btn btn-info" onClick="$('#plotly').modal('show');">View Open Contract</button>` ));

                                    notify('success', 'Trade: Fall');
                                }

                            } else if (response.value == 2) {
                                notify('error', response.message);
                            } else {
                                $.each(response, function (i, val) {
                                    notify('error', val)
                                });
                            }
                        }
                    });
                }
            });

            function secondCount() {
                if (playTimeUnit == 'Sec') {
                    second = playTime;
                    return second;
                } else if (playTimeUnit == 'Min') {
                    second = playTime * 60;
                    return second;
                } else if (playTimeUnit == 'Hour') {
                    second = playTime * 60 * 60;
                    return second;
                }
            }

            function countDown(timeCount, tradeLogId) {
                var clock = $('.clock').FlipClock({
                    clockFace: 'MinuteCounter',
                    language: 'en',
                    autoStart: false,
                    countdown: true,
                    showSeconds: true,
                    callbacks: {
                        stop: function () {
                            gameResult(tradeLogId)
                        }
                    }
                });
                clock.setTime(timeCount - 1);
                clock.setCountdown(true);
                clock.start();
            }

            function gameResult(tradeLogId) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('user.binary.trade.result') }}",
                    method: "POST",
                    data: {
                        tradeLogId: tradeLogId,
                        pair: pair,
                        obj: obj
                    },
                    success: function (response) {
                        if (response == 1) {
                            notify('success', 'Trade Win');
                        } else if (response == 2) {
                            notify('error', 'Trade Lose');
                        } else if (response == 3) {
                            notify('error', 'Trade Draw');
                        } else {
                            $.each(response, function (i, val) {
                                notify('error', val)
                            });
                        }
                        setTimeout(function () {
                            /*ws_i.send(JSON.stringify({
                                'method': 'UNSUBSCRIBE',
                                'params': ['{{strtolower($symbol)}}{{strtolower($pair)}}@miniTicker'],
                                'id': 4
                            }))*/
                            //$('#plotly').modal('hide');
                            //Livewire.emit('plotlyRefresh')
                            location.reload();
                        }, 1000);
                    }
                });
            }
        });
    </script>
@endpush
