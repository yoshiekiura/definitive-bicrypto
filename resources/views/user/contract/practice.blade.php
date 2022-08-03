@extends('layouts.app')
@php
use mobiledetect\mobiledetectlib\Detection;
$detect = new Mobile_Detect();
@endphp
@section('vendor-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.css">
    <style>
        .content-wrapper {
            padding: 3px;
        }

        .app-content {
            padding: calc(2rem + 2.45rem) 0 0 0rem !important;
            overflow-x: hidden;
            font-family: BinancePlex, Arial, sans-serif !important;
        }

        @media (max-width: 767.98px) {
            html body.navbar-sticky .app-content {
                padding: calc(1rem - 0.8rem + 4.45rem) 0 0 0 !important;
            }
        }

        #app-conainer {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-content: space-between;
            align-items: flex-start;
            flex-wrap: nowrap;
        }

        .tabbable .nav-tabs {
            overflow-x: auto;
            overflow-y: hidden;
            flex-wrap: nowrap;
        }

        .tabbable .nav-tabs .nav-link {
            white-space: nowrap;
        }

        .tableFixHead {
            overflow: auto;
            height: 100px;
        }

        .tableFixHead thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        table {
            font-size: 13px;
            font-weight: 500;
            color: rgb(183, 189, 198);
            overflow: hidden;
            width: 100%;
        }

        td {
            position: relative;
            height: 20px;
            line-height: 20px;
        }

        td.price {
            width: 30%;
        }

        td.price span {
            padding-left: 5px;
        }

        td.quantity {
            width: 30%;
            text-align: right;
        }

        td.time {
            width: 40%;
            text-align: right;
            color: #999;
            padding-right: 5px;
        }

        td.btc {
            width: 40%;
            text-align: right;
            padding-right: 5px;
        }

        td span {
            position: relative;
            z-index: 2;
        }

        table.asks .percent {
            background-color: rgba(246, 70, 94, 0.2);
        }

        table.bids .percent {
            background-color: rgba(14, 203, 129, 0.2);
        }

        table.asks_only .percent {
            background-color: rgba(246, 70, 94, 0.2);
        }

        table.bids_only .percent {
            background-color: rgba(14, 203, 129, 0.2);
        }

        td .percent {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
        }

        .hidden {
            display: none;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row match-height">
            <div class="col-12 col-lg-9 bordered darked px-0">
                <div class="d-flex d-lg-none justify-content-between align-items-center text-2">
                    <div class="d-flex flex-column">
                        <span class="text-muted">Last Price: <span class="last_price">------</span><i
                                class="last_price_icon bi"></i></span>
                        <span class="text-muted">24h Change: <span class="day_change">------</span><i
                                class="day_change_icon bi"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-muted d-none d-md-block">{{ $symbol }} Volume: <span
                                class="text-dark day_volume_pair">------</span></span>
                        <span class="text-muted d-none d-md-block">{{ $currency }} Volume: <span
                                class="text-dark day_volume_currency">------</span></span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-muted">24h High: <span class="text-dark day_high">------</span></span>
                        <span class="text-muted">24h Low: <span class="text-dark day_low">------</span></span>
                    </div>
                </div>
                <div class="d-none d-lg-flex align-items-center p-1 text-2">
                    <div class="d-flex align-items-center me-3">
                        <img class="avatar-content" width="24px"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($symbol) . '.png') }}"
                            alt="{{ $symbol }}">
                        <i class="bi bi-chevron-right"></i>
                        <img class="avatar-content" width="24px"
                            src="{{ getImage('assets/images/cryptoCurrency/' . strtolower($currency) . '.png') }}"
                            alt="{{ $currency }}">
                    </div>
                    <div class="d-flex flex-column me-3">
                        <span class="text-muted">24h change</span>
                        <span class="day_change">
                            -------
                        </span>
                    </div>
                    <div class="d-flex flex-column me-3">
                        <span class="text-muted">24h Price Range</span>
                        <span class="text-muted">High: <span class="text-dark day_high">-------</span></span>
                        <span class="text-muted">Low: <span class="text-dark day_low">-------</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-muted">24h Volume</span>
                        <span class="text-muted">{{ $symbol }}: <span
                                class="text-dark day_volume_pair">-------</span></span>
                        <span class="text-muted">{{ $currency }}: <span
                                class="text-dark day_volume_currency">-------</span></span>
                    </div>
                </div>
                <!-- TradingView Widget BEGIN -->
                <div id="tradingview_{{ grs() }}" class="bordered-t "></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                    new TradingView.widget({
                        "width": "100%",
                        "height": "400",
                        "symbol": "BINANCE:{{ strtoUpper($symbol) }}{{ strtoUpper($currency) }}",
                        "interval": "H",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "1",
                        "locale": "en",
                        "toolbar_bg": "#f1f3f6",
                        "enable_publishing": false,
                        "hide_legend": true,
                        "save_image": false,
                        "container_id": "tradingview_{{ grs() }}"
                    });
                </script>
                <!-- TradingView Widget END -->
                <div class="bordered-t darked px-0">
                    <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-market-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-market" type="button" role="tab" aria-controls="pills-market"
                                aria-selected="true">Rise/Fall</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-limit-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-limit" type="button" role="tab" aria-controls="pills-limit"
                            aria-selected="false">Limit</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-funds-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-funds" type="button" role="tab" aria-controls="pills-funds"
                            aria-selected="false">Funds</button>
                    </li> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-market" role="tabpanel"
                            aria-labelledby="pills-market-tab">
                            <form id="Order">
                                <div class="row pb-1 px-1">
                                    <div class="col-6">
                                        <label for="basic-url"
                                            class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                            <span>Time</span>
                                        </label>
                                        <div class="input-group input-group-sm mb-1">
                                            <input type="number" class="form-control bg-black text-dark border-0"
                                                min="{{ $limit->min_time_sec }}" max="{{ $limit->max_time_sec }}"
                                                required="" id="time" name="time" placeholder="Time">
                                            <button
                                                class="btn btn-outline-secondary dropdown-toggle bg-black text-dark border-0"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                id="timed">Sec</button>
                                            <ul class="dropdown-menu dropdown-menu-end" id="timer">
                                                <li><a id="sec" name="sec" value="sec" min="{{ $limit->min_time_sec }}"
                                                        max="{{ $limit->max_time_sec }}" href="javascript:void(0)"
                                                        class="dropdown-item">Sec</a></li>
                                                <li><a id="min" name="min" value="min" min="{{ $limit->min_time_min }}"
                                                        max="{{ $limit->max_time_min }}" href="javascript:void(0)"
                                                        class="dropdown-item">Min</a></li>
                                                <li><a id="hour" name="hour" value="hour"
                                                        min="{{ $limit->min_time_hour }}"
                                                        max="{{ $limit->max_time_hour }}" href="javascript:void(0)"
                                                        class="dropdown-item">Hour</a></li>
                                            </ul>
                                        </div>
                                        <label for="basic-url"
                                            class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                            <span>Amount</span>
                                        </label>
                                        <div class="input-group input-group-sm mb-1">
                                            <input type="number" class="form-control bg-black text-dark border-0"
                                                min="{{ $limit->min_amount }}" max="{{ $limit->max_amount }}"
                                                step="0.00000001" required="" id="amount" name="amount" id="amount"
                                                placeholder="Amount" aria-label="Amount (to the nearest dollar)">
                                            <span
                                                class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                        </div>
                                        {{-- <label for="basic-url"
                                        class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                        <span>Total</span>
                                    </label>
                                    <div class="input-group input-group-sm mb-1">
                                        <input type="number" class="form-control bg-black text-dark border-0" disabled
                                            aria-label="Amount (to the nearest dollar)" id="totalAmount">
                                        <span class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                    </div> --}}
                                        <div class="d-grid mt-1">
                                            <button class="btn btn-success btn-sm RiseBtn" type="submit"><i
                                                    class="bi bi-graph-up"></i> Rise</button>
                                        </div>
                                    </div>
                                    <div class="col-6">

                                        @livewire('binary.practice.balance', ['symbol' => $symbol, 'currency' => $currency])
                                        <div class="d-grid mt-1">
                                            <button class="btn btn-danger btn-sm FallBtn" type="submit"><i
                                                    class="bi bi-graph-down"></i> Fall</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="tab-pane fade" id="pills-limit" role="tabpanel" aria-labelledby="pills-limit-tab">
                        <div class="row pb-1 px-1">
                            <div class="col-6">
                                <form class="text-center mt-1" id="limitFormBuy">
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Price</span>
                                    <span class="text-dark">Best Ask</span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0 priceNowAsk" step="0.00000001" required="" id="price"
                                    name="priceBuy" placeholder="Price"
                                        aria-label="Amount (to the nearest dollar)">
                                    <span class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                    <span class="input-group-text bg-black text-dark border-0 ms-1">
                                        <i class="bi bi-caret-up-fill"></i>
                                        <i class="bi bi-caret-down-fill"></i>
                                    </span>
                                </div>
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Amount</span>
                                    <span>
                                        <a class="text-dark" onclick="getPercBuy('.LimitBuy','#totalbuylimit','0.25')">25%</a>
                                        <a class="text-dark" onclick="getPercBuy('.LimitBuy','#totalbuylimit','0.5')">50%</a>
                                        <a class="text-dark" onclick="getPercBuy('.LimitBuy','#totalbuylimit','0.75')">75%</a>
                                        <a class="text-dark" onclick="getPercBuy('.LimitBuy','#totalbuylimit','1')">100%</a>
                                    </span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0 LimitBuy" min="{{ $limit->min_amount }}" max="{{ $limit->max_amount }}"  step="0.00000001" required="" id="amount"
                                    name="amountLimitBuy"
                                        aria-label="Amount (to the nearest dollar)" onkeyup="getPriceBuy('.LimitBuy','#totalbuylimit')">
                                    <span class="input-group-text bg-black text-dark border-0">{{ $symbol }}</span>
                                </div>
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Total</span>
                                    <span>Processing Fee: <span class="text-warning">%</span></span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0"
                                        aria-label="Amount (to the nearest dollar)" id="totalbuylimit" disabled>
                                    <span class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                </div>
                                <div class="d-grid mt-1">
                                    <button class="btn btn-success btn-sm limitType" id="limitOrderBtnBuy" type="submit">Buy</button>
                                </div>
                            </form>
                            </div>
                            <div class="col-6">
                                <form class="text-center mt-1" id="limitFormSell">
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Price</span>
                                    <span class="text-dark">Best Bid</span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0 priceNowBid" step="0.00000001" required="" id="price"
                                    name="priceSell" placeholder="Price"
                                        aria-label="Amount (to the nearest dollar)">
                                    <span class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                    <span class="input-group-text bg-black text-dark border-0 ms-1">
                                        <i class="bi bi-caret-up-fill"></i>
                                        <i class="bi bi-caret-down-fill"></i>
                                    </span>
                                </div>
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Amount</span>
                                    <span>
                                        <a class="text-dark" onclick="getPercSell('.LimitSell','#totalselllimit','0.25')">25%</a>
                                        <a class="text-dark" onclick="getPercSell('.LimitSell','#totalselllimit','0.5')">50%</a>
                                        <a class="text-dark" onclick="getPercSell('.LimitSell','#totalselllimit','0.75')">75%</a>
                                        <a class="text-dark" onclick="getPercSell('.LimitSell','#totalselllimit','1')">100%</a>
                                    </span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0 LimitSell" min="{{ $limit->min_amount }}" max="{{ $limit->max_amount }}"  step="0.00000001" required="" id="amount"
                                    name="amountLimitSell"
                                        aria-label="Amount (to the nearest dollar)" onkeyup="getPriceSell('.LimitSell','#totalselllimit')">
                                    <span class="input-group-text bg-black text-dark border-0">{{ $symbol }}</span>
                                </div>
                                <label for="basic-url"
                                    class="form-label mb-1 d-flex justify-content-between text-1 text-dark">
                                    <span>Total</span>
                                    <span>Processing Fee: <span class="text-warning">%</span></span>
                                </label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="number" class="form-control bg-black text-dark border-0"
                                        aria-label="Amount (to the nearest dollar)" id="totalselllimit" disabled>
                                    <span class="input-group-text bg-black text-dark border-0">{{ $currency }}</span>
                                </div>
                                <div class="d-grid mt-1">
                                    <button class="btn btn-danger btn-sm limitType" id="limitOrderBtnSell" type="submit">Sell</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-funds" role="tabpanel" aria-labelledby="pills-funds-tab">
                    </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 bordered darked px-0">
                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-graph-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-graph" type="button" role="tab" aria-controls="pills-graph"
                            aria-selected="false">
                            <i class="bi bi-graph-up text-dark"></i>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-graph-up-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-graph-up" type="button" role="tab" aria-controls="pills-graph-up"
                            aria-selected="false">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-graph-down-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-graph-down" type="button" role="tab" aria-controls="pills-graph-down"
                            aria-selected="false">
                            <i class="bi bi-graph-down-arrow text-danger"></i>
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-graph-tabContent">
                    <div class="tab-pane fade show active" id="pills-graph" role="tabpanel"
                        aria-labelledby="pills-graph-tab">

                        <div class="table-responsive">
                            <table class="table text-dark table-sm table-borderless" style="overflow-x:hidden;">
                                <thead class="text-muted">
                                    <tr>
                                        <th class="text-start" scope="col">Price</th>
                                        <th class="text-start" scope="col">Amount</th>
                                        <th class="text-end" scope="col">Total</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="asks"></table>
                        </div>

                        <div class="table-responsive bordered-y">
                            <table class="table text-dark table-sm table-borderless my-auto">
                                <tbody>
                                    <tr>
                                        <td class="text-mute ">
                                            <span class="fs-6">Last Price: </span>
                                            <span class="fs-6 best_ask"></span><i class="fs-5 best_ask_icon bi"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="bids"></table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-graph-down" role="tabpanel"
                        aria-labelledby="pills-graph-down-tab">
                        <div class="table-responsive">
                            <table class="table text-dark table-sm table-borderless">
                                <thead class="text-muted">
                                    <tr>
                                        <th scope="col">Price</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="asks_only"></table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-graph-up" role="tabpanel" aria-labelledby="pills-graph-up-tab">
                        <div class="table-responsive">
                            <table class="table text-dark table-sm table-borderless">
                                <thead class="text-muted">
                                    <tr>
                                        <th scope="col">Price</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="bids_only"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 darked px-0">
                <div class="bordered-t darked px-0 ordercard hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="clock"></div>
                            </div>
                            <div class="col">
                                <div><span class="text-warning">Order Type: </span><span class="trade-user-type"></span>
                                </div>
                                <div><span class="text-warning">Price Was: </span><span class="trade-user-price"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Chart"></div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-12 bordered darked px-0 d-none d-md-block ">
                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Open Orders</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Order History</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <table class="table text-dark table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">TxHash</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Pair</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Price Was</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                @livewire('binary.practice.open-orders', ['symbol' => $symbol, 'currency' => $currency])
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="table-responsive">
                            <table class="table text-dark table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">TxHash</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Pair</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Price Was</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                @livewire('binary.practice.order-history', ['symbol' => $symbol, 'currency' => $currency])
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/data.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        "use strict";
        let ws = new WebSocket(
            'wss://stream.binance.com:9443/ws/{{ strtolower($symbol) }}{{ strtolower($currency) }}@depth20@100ms');
        let ticker = new WebSocket('wss://stream.binance.com:9443/ws');
        let tick = new WebSocket('wss://stream.binance.com:9443/ws');
        var bestAsk;
        var bestAsker;
        var last_price;
        var day_change;
        var bestAsker;

        document.addEventListener("DOMContentLoaded", function() {
            var computBarWidth = {
                width: 250,
                sortDepth: {
                    sort: function(e) {
                        return e.sort(function(e, t) {
                            return e[1] - t[1]
                        }), e
                    },
                    median: function(e) {
                        var t = Math.floor(e.length / 3 * 2);
                        return e[t][1] < 1 ? 1 : e[t][1]
                    },
                    medianUnit: function(e, t, n) {
                        var r = new Array(e);
                        r = r[0];
                        var o = new Array(t);
                        o = o[0], r = r.concat(o);
                        var i = this.median(this.sort(r)) / n;
                        return o = r = null, i
                    },
                    width: function(e, t) {
                        if (0 == t) return 1;
                        var n = Math.round(Number(e) / t);
                        return n <= 0 ? 1 : 160 < n ? 160 : n
                    }
                },
                init: function(e, t) {
                    var n = [],
                        r = [];
                    e.forEach(function(e) {
                        n.push(e);
                    }), t.forEach(function(e) {
                        r.push(e)
                    });
                    var o = this.sortDepth.medianUnit(n, r, 48);
                    e.forEach(function(e) {
                        e.push({
                            width: computBarWidth.sortDepth.width(e[1], o) * computBarWidth
                                .width / 100
                        })
                    }), t.forEach(function(e) {
                        e.push({
                            width: computBarWidth.sortDepth.width(e[1], o) * computBarWidth
                                .width / 100
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

                var toFixedFix = function(n, prec) {
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
            ws.onmessage = function(event2) {
                let data = JSON.parse(event2.data);

                computBarWidth.init(data.bids, data.asks);
                this.best_asks = $('.best_ask');
                this.best_ask_Icons = $('.best_ask_icon');
                const best_ask = this.best_asks;
                const best_ask_Icon = this.best_ask_Icons;
                bestAsk = data.asks[0][0]
                if (!bestAsker || bestAsk > bestAsker) {
                    best_ask.text(bestAsk)
                    best_ask.toggleClass('text-success')
                    best_ask_Icon.addClass('bi-arrow-up text-success').removeClass('bi-arrow-down text-danger')
                } else if (bestAsk < bestAsker) {
                    best_ask.text(bestAsk)
                    best_ask.toggleClass('text-danger')
                    best_ask_Icon.addClass('bi-arrow-down text-danger').removeClass('bi-arrow-up text-success')
                }
                bestAsker = bestAsk;
                $('.asks,.bids,.asks_only,.bids_only').empty();

                $.each(data.asks, function(index, item) {
                    let row = $('<tr>')
                        .append($('<td>').css("color", "rgb(246,70,93)").addClass("price").append($(
                            "<span>").text(Number(item[0]).toFixed(2))))
                        .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1])
                            .toFixed(6))))
                        .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[
                                0] * item[1]), 2, ",")))
                            .append($("<div>").addClass("percent").css("width", item[2].width + "px")));
                    if (index > 12) row.hide();

                    $('.asks').prepend(row);
                });
                $.each(data.asks, function(index, item) {
                    let row = $('<tr>')
                        .append($('<td>').css("color", "rgb(246,70,93)").addClass("price").append($(
                            "<span>").text(Number(item[0]).toFixed(2))))
                        .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1])
                            .toFixed(6))))
                        .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[
                                0] * item[1]), 2, ",")))
                            .append($("<div>").addClass("percent").css("width", item[2].width + "px")));

                    if (index > 20) row.hide();

                    $('.asks_only').prepend(row);
                });
                $.each(data.bids, function(index, item) {
                    let row = $('<tr>')
                        .append($('<td>').css("color", "rgb(14,203,129)").addClass("price").append($(
                            "<span>").text(Number(item[0]).toFixed(2))))
                        .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1])
                            .toFixed(6))))
                        .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[
                                0] * item[1]), 2, ",")))
                            .append($("<div>").addClass("percent").css("width", item[2].width + "px")));

                    if (index > 12) row.hide();

                    $('.bids').prepend(row);
                });
                $.each(data.bids, function(index, item) {
                    let row = $('<tr>')
                        .append($('<td>').css("color", "rgb(14,203,129)").addClass("price").append($(
                            "<span>").text(Number(item[0]).toFixed(2))))
                        .append($('<td>').addClass("quantity").append($("<span>").text(Number(item[1])
                            .toFixed(6))))
                        .append($('<td>').addClass("btc").append($("<span>").text(number_format((item[
                                0] * item[1]), 2, ",")))
                            .append($("<div>").addClass("percent").css("width", item[2].width + "px")));

                    if (index > 20) row.hide();

                    $('.bids_only').prepend(row);
                });
            }
        });
        ticker.addEventListener('open', (tickersEvent) => {
            ticker.send(JSON.stringify({
                'method': 'SUBSCRIBE',
                'params': ['{{ strtolower($symbol) }}{{ strtolower($currency) }}@ticker'],
                'id': 1
            }))
            ticker.onmessage = function(tickersEvent) {
                let data = JSON.parse(tickersEvent.data);
                this.tickElements = $('.last_price')
                this.tickIcons = $('.last_price-icon')
                const tickElement = this.tickElements
                const tickIcon = this.tickIcons
                if (!last_price || parseFloat(data.c) > last_price) {
                    tickElement.text(parseFloat(data.c))
                    tickElement.toggleClass('text-success')
                    tickIcon.toggleClass('bi-arrow-up text-success')
                } else if (parseFloat(data.c) < last_price) {
                    tickElement.text(parseFloat(data.c))
                    tickElement.toggleClass('text-danger')
                    tickIcon.toggleClass('bi-arrow-down text-danger')
                }
                last_price = parseFloat(data.c);
                this.percentageElements = $('.day_change')
                this.percentageIcons = $('.day_change-icon')
                const percentageElement = this.percentageElements
                const percentageIcon = this.percentageIcons
                if (!day_change || parseFloat(data.P) > day_change) {
                    percentageElement.text(parseFloat(data.P))
                    percentageElement.toggleClass('text-success')
                    percentageIcon.toggleClass('bi-arrow-up text-success')
                } else if (parseFloat(data.P) < day_change) {
                    percentageElement.text(parseFloat(data.P))
                    percentageElement.toggleClass('text-danger')
                    percentageIcon.toggleClass('bi-arrow-down text-danger')
                }
                day_change = parseFloat(data.P);

                this.day_volume_pairs = $('.day_volume_pair')
                const day_volume_pair = this.day_volume_pairs
                day_volume_pair.text(new Intl.NumberFormat().format(parseFloat(data.v)))

                this.day_volume_currencys = $('.day_volume_currency')
                const day_volume_currency = this.day_volume_currencys
                day_volume_currency.text(new Intl.NumberFormat().format(parseFloat(data.q)))

                this.day_highs = $('.day_high')
                const day_high = this.day_highs
                day_high.text(parseFloat(data.h))

                this.day_lows = $('.day_low')
                const day_low = this.day_lows
                day_low.text(parseFloat(data.x))

            }
        });
        $(document).ready(async function() {
            $('.icon-unlock').hover(function() {
                $(this).addClass('bi-star-fill');
                $(this).removeClass('bi-star');
            }, function() {
                $(this).addClass('bi-star');
                $(this).removeClass('bi-star-fill');
            });
            var obj = [];
            var json = JSON.stringify(obj);
            var tradeLogId;
            var second;
            var OrderTimeUnit;
            var OrderTime;
            var OrderType;
            var currency = "{{ $currency }}";
            var symbol = "{{ $symbol }}";
            let message = [];
            var dataframe;
            const userBalance = '{{ auth()->user()->practice_balance }}';

            $("#timer").on('click', 'li a', function() {
                $("#timed").text($(this).text());
                $("#time").attr('min', $(this).attr('min'));
                $("#time").attr('max', $(this).attr('max'));
            });
            $(".RiseBtn").on('click', function() {
                OrderType = 1;
                OrderTime = $("#time").val();
                OrderTimeUnit = $("#timed").text();
            })
            $(".FallBtn").on('click', function() {
                OrderType = 2;
                OrderTime = $("#time").val();
                OrderTimeUnit = $("#timed").text();
            })

            $("#Order").on('submit', function(event4) {
                event4.preventDefault();
                $(".RiseBtn").prop('disabled', true);
                $(".FallBtn").prop('disabled', true);
                Livewire.emit('refreshBalance');
                var amount = $('input[name="amount"]').val();
                var timeCount = secondCount();

                if (tick.readyState == WebSocket.OPEN) {
                    if (userBalance < amount) {
                        notify('error',
                            'Your Practice Balance {{ getAmount(auth()->user()->practice_balance) }} {{ $currency }} Not Enough! Please Add Practice Amount'
                            );
                    } else if (isNaN(amount) || amount <= 0) {
                        notify('error', 'Please Insert Valid Amount')
                    } else if (isNaN(timeCount) || timeCount <= 0) {
                        notify('error', 'Please Select Valid Time')
                    } else {
                        $('.ordercard').removeClass('hidden');
                        tick.send(JSON.stringify({
                            'method': 'SUBSCRIBE',
                            'params': [
                                '{{ strtolower($symbol) }}{{ strtolower($currency) }}@miniTicker'
                            ],
                            'id': 1
                        }))
                        const chart = new Highcharts.chart('Chart', {
                            chart: {
                                backgroundColor: '#22292F',
                                type: 'spline',
                                animation: Highcharts.svg,
                                marginRight: 10,
                                events: {
                                    load: function() {
                                        tick.onmessage = (tickEvent) => {
                                            message = JSON.parse(tickEvent.data)
                                            if (message.E != null) {
                                                let c = Number(message.c);
                                                let E = Number(message.E);
                                                dataframe = [E, c];
                                                chart.series[0].addPoint(dataframe,
                                                    true);
                                                obj.push({
                                                    time: E,
                                                    value: c
                                                });
                                            }
                                        }
                                    }
                                }
                            },
                            time: {
                                useUTC: false
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true,
                                    minAnnounceInterval: 15000,
                                    announcementFormatter: function(allSeries, newSeries,
                                        newPoint) {
                                        if (newPoint) {
                                            return 'New point added. Value: ' + newPoint.y;
                                        }
                                        return false;
                                    }
                                }
                            },

                            title: {
                                text: '{{ $symbol }}/{{ $currency }}',
                                style: {
                                    color: '#fff',
                                }
                            },
                            xAxis: {
                                type: 'datetime',
                                tickPixelInterval: 150,
                                lineColor: '#fff',
                                tickColor: '#fff',
                                labels: {
                                    style: {
                                        color: '#fff',
                                    }
                                },
                                title: {
                                    style: {
                                        color: '#fff',
                                    }
                                },
                            },

                            yAxis: {
                                lineColor: '#fff',
                                tickColor: '#fff',
                                labels: {
                                    style: {
                                        color: '#fff',
                                    }
                                },
                                title: {
                                    text: 'Price',
                                    style: {
                                        color: '#fff',
                                    }
                                },
                                plotLines: [{
                                    value: 0,
                                    width: 1,
                                    color: '#fff'
                                }]
                            },

                            tooltip: {
                                headerFormat: '<b>{point.y:.2f}</b><br/>',
                                pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>'
                            },

                            legend: {
                                enabled: false
                            },

                            exporting: {
                                enabled: false
                            },
                            series: [{
                                boostThreshold: 1
                            }],
                            credits: {
                                enabled: false
                            },
                        });
                        $('input[name="amount"]').val("");
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            url: "{{ route('user.binary.practice.store') }}",
                            method: "POST",
                            data: {
                                amount: amount,
                                symbol: symbol,
                                OrderType: OrderType,
                                duration: OrderTime,
                                currency: currency,
                                unit: OrderTimeUnit,
                            },
                            success: function(response) {
                                if (response.value == 1) {
                                    tradeLogId = response.tradeLogId;
                                    countDown(timeCount, tradeLogId)
                                    if (OrderType == 1) {
                                        $(".trade-user-type").text("Rise");
                                        $(".trade-user-price").text(response.trade + " " +
                                            "{{ $currency }}");
                                        notify('success', 'Trade: Rise');
                                    } else {
                                        $(".trade-user-type").text("Fall");
                                        $(".trade-user-price").text(response.trade + " " +
                                            "{{ $currency }}");
                                        notify('success', 'Trade: Fall');
                                    }
                                } else if (response.value == 2) {
                                    notify('error', response.message);
                                } else {
                                    $.each(response, function(i, val) {
                                        notify('error', val)
                                    });
                                }
                            }
                        });
                    }
                } else {
                    $(".RiseBtn").prop('disabled', false);
                    $(".FallBtn").prop('disabled', false);
                    notify('error', 'Please Try Again')
                }
            });

            function secondCount() {
                if (OrderTimeUnit == 'Sec') {
                    second = OrderTime;
                    return second;
                } else if (OrderTimeUnit == 'Min') {
                    second = OrderTime * 60;
                    return second;
                } else if (OrderTimeUnit == 'Hour') {
                    second = OrderTime * 60 * 60;
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
                        stop: function() {
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
                    url: "{{ route('user.binary.practice.result') }}",
                    method: "POST",
                    data: {
                        tradeLogId: tradeLogId,
                        currency: currency,
                        obj: obj
                    },
                    success: function(response) {
                        Livewire.emit('refreshBalance');
                        tick.send(JSON.stringify({
                            'method': 'UNSUBSCRIBE',
                            'params': [
                                '{{ strtolower($symbol) }}{{ strtolower($currency) }}@miniTicker'
                            ],
                            'id': 1
                        }))
                        if (response == 1) {
                            notify('success', 'Trade Win');
                        } else if (response == 2) {
                            notify('error', 'Trade Lose');
                        } else if (response == 3) {
                            notify('error', 'Trade Draw');
                        } else {
                            $.each(response, function(i, val) {
                                notify('error', val)
                            });
                        }
                        setTimeout(function() {
                            $('#Chart').highcharts().destroy();
                            $('.ordercard').addClass('hidden');
                            $(".RiseBtn").prop('disabled', false);
                            $(".FallBtn").prop('disabled', false);
                        }, 1000);
                    }
                });
            }
        });
    </script>
@endsection
