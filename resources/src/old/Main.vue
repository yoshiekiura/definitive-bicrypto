<template>
    <div class="flex-start col-10 col-xll-10 col-xl-10 col-lg-10 col-md-9 col-sm-12">
        <div id="tvjs-header">
            <a><span v-on:click="candles" class="me-1 badge bg-light-secondary"><i class="bi bi-bar-chart" /><div class="d-md-inline d-none">  Candles</div></span></a>
            <a><span v-on:click="spline" class="me-1 badge bg-light-secondary"><i class="bi bi-graph-up" /><div class="d-md-inline d-none">  Spline</div></span></a>
            <a><span id="toggleInfo" class="me-1 badge bg-light-info" data-bs-toggle="collapse"
                    data-bs-target="#collapseInfos" aria-expanded="false" aria-controls="collapseInfos"><i
                        class="bi bi-info-circle" /><div class="d-md-inline d-none">  Info</div></span></a>
            <a><span id="toggleDepth" class="me-1 badge bg-light-primary " data-bs-toggle="collapse"
                    data-bs-target="#collapseDepth" aria-expanded="false" aria-controls="collapseDepth"><i
                        class="bi bi-kanban" /><div class="d-md-inline d-none">  Depth View</div></span></a>
            <a><span id="toggleOrders" class="me-1 badge bg-light-warning " data-bs-toggle="collapse"
            data-bs-target="#collapseOrders" aria-expanded="false" aria-controls="collapseOrders"><i
                        class="bi bi-file-bar-graph" /><div class="d-md-inline d-none">  Order Book</div></span></a>
            </div>
            <div id="collapseInfos"
                class="collapse col-lg-4 col-md-5 col-sm-6 position-absolute sticky-top card-110 ">
                <div class="card" style="background:#131722e6!important;box-shadow: 0 4px 24px 0 rgb(0 0 0 / 30%);">
                    <div class="card-header">
                        <div class="col-md-8">
                            <h4 class="card-title">
                                {{ symbol }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div id="show_b" class="text-start fs-1">
                                        ...
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div id="show_p" class="text-end" style="font-size:14px;">
                                        ...
                                    </div>
                                    <div id="show_P" class="text-end" style="font-size:14px;">
                                        ...
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div id="myRangeColor" class="progress">
                                    <div id="myRange" class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 80%" />
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between align-items-center">
                                <div id="show_l" class="col text-start text-danger" style="font-size:10px;" />
                                <div class="col text-dark text-center" style="font-size:10px;">
                                    Day Range
                                </div>
                                <div id="show_h" class="col text-end text-success" style="font-size:10px;" />
                            </div>
                            <div class="row mt-1">
                                <small class="col text-start text-dark clearfix">Volume 24H</small>
                                <small id="show_v" class="col text-end text-warning clearfix" />
                                <hr>
                            </div>
                            <div class="row">
                                <small class="col text-start text-dark clearfix">Market Cap</small>
                                <small id="show_mc" class="col text-end text-warning clearfix" />
                                <hr>
                            </div>

                            <div class="row">
                                <small class="col text-start text-dark clearfix">Total Supply</small>
                                <small id="show_ts" class="col text-end text-warning clearfix" />
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapseDepth"
                class="collapse col-lg-6 col-md-10 col-sm-12 col-12 position-absolute sticky-top card-110 ">
                <div class="card" style="background:#131722e6!important;box-shadow: 0 4px 24px 0 rgb(0 0 0 / 30%);">
                    <div class="card-content">
                        <div id="chartdiv"></div>
                    </div>
                </div>
            </div>
            <div id="collapseOrders"
                class="collapse col-lg-4 col-md-4 col-sm-6 col-12 position-absolute sticky-top card-110" style="max-width:280px;">
                <div class="card" style="background:#131722e6!important;box-shadow: 0 4px 24px 0 rgb(0 0 0 / 30%);">
                    <div class="card-content my-1">
                        <div class="box">
                            <table>
                                <thead>
                                    <tr class="mb-1">
                                        <th class="text-start ps-1 text-dark">
                                            Price
                                        </th>
                                        <th class="text-center ps-1 text-dark">
                                            Quantity
                                        </th>
                                        <th class="text-end pe-1 text-dark">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="asks" />
                            <div class="newest" />
                            <table class="bids" />
                        </div>
                    </div>
                </div>
            </div>
        <div class="app-container" style="margin-top:40px;">
            <trading-vue :key="resetkey" ref="tvjs" :data="dc" :width="width" :height="height" :title-txt="title"
                color-title="#ff9f43" :legend-buttons="['display', 'settings', 'up', 'down', 'add', 'remove']"
                :chart-config="{DEFAULT_LEN:60,MIN_ZOOM:1}" :toolbar="true" :color-back="colors.colorBack"
                :color-grid="colors.colorGrid" :color-text="colors.colorText" :extensions="ext" :overlays="ovs"
                :night="night" :resetkey="resetkey" :x-settings="xsett" :timezone="timezone" />
        </div>
    </div>
</template>

<script>
import { TradingVue, DataCube } from 'trading-vue-js'
import Overlays from 'tvjs-overlays'
import Data from '../resources/data/data.json'
import Utils from './stuff/utils.js'
import Const from './stuff/constants.js'
import Stream from './stream.js'
import Extensions from './index_dev'
import txt from 'raw-loader!../resources/assets/cors.txt';
// Gettin' data through webpeck proxy
const symbolsm = window.location.pathname.toLowerCase().split('/')[3]
const symbolbg = window.location.pathname.toUpperCase().split('/')[3]
const pairsm = window.location.pathname.toLowerCase().split('/')[4]
const pairbg = window.location.pathname.toUpperCase().split('/')[4]
const URL = txt+'https://api.binance.com/api/v1/klines?symbol='
const WSS = `wss://stream.binance.com:9443/ws/${symbolsm}${pairsm}@aggTrade`
const datas = `datasets.binance-${symbolsm}${pairsm}`
//const PORT = location.port
//const URL = `http://localhost:${PORT}/api/v1/klines?symbol=`
//const WSS = `ws://localhost:${PORT}/ws/${symbolsm}@aggTrade`

export default {
    name: 'App',
    components: {
        TradingVue
    },
    data() {
        return {
            dc: new DataCube(Data),
            title: symbolbg + pairbg,
            width: 0,
            height: 0,
            log_scale: true,
            symbol: symbolbg + pairbg,
            index_based: true,
            timezone: this.timezoned(),
            xsett: {
                'grid-resize': { min_height: 30 }
            },
            ovs: Object.values(Overlays),
            ext: Object.values(Extensions),
            night: true,
            top: 50,
            resetkey: 0
        }
    },
    computed: {
        colors() {
            return this.night ? {} : {
                colorBack: '#fff',
                colorGrid: '#eee',
                colorText: '#333'
            }
        }
    },
    mounted() {
        window.addEventListener('resize', this.onResize)
        let q = this.win_query()
        if (q.nm === 'false') this.night = false
        if (q.ov) this.current = q.ov
        if (q.header === 'false') this.top = 0
        this.onResize(),
        window.dc = this.dc
        window.tv = this.$refs.tvjs
        // Load the last data chunk & init DataCube:
        let now = Utils.now()
        this.load_chunk([now - Const.HOUR4, now]).then(data => {
            dc.data.chart.data = data['chart.data']
            // Register onrange callback & And a stream of trades
            this.dc.onrange(this.load_chunk)
            this.stream = new Stream(WSS)
            this.stream.ontrades = this.on_trades
            window.dc = this.chart      // Debug
            window.tv = this.$refs.tvjs // Debug
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize)
        if (this.stream) this.stream.off()
    },
    methods: {
        onResize() {
            if (window.innerWidth > '992') {
                this.width = (window.innerWidth - (window.innerWidth * 0.21))
            } else if (window.innerWidth > '768'  && window.innerWidth <= '992') {
                this.width = (window.innerWidth - (window.innerWidth * 0.26))
            } else {
                this.width = (window.innerWidth - 15)
            }
            this.height = window.innerHeight * 0.80
        },
        spline () {
            this.dc.data.chart.type = "Spline"
            this.dc.data.chart.tf = "1m"
            this.$refs.tvjs.resetChart()
        },
        candles () {
            this.dc.data.chart.type = "Candles"
            this.dc.data.chart.tf = "1m"
            this.$refs.tvjs.resetChart()
        },
        xbars () {
            this.data.ovs = 'XOhlcBars'
            this.dc.data.chart.tf = "1m"
            this.$refs.tvjs.resetChart()
        },
        trade () {
            this.dc.data.chart.type = "Spline"
        },
        win_query() {
            let qs = (function(a) {
                if (a == "") return {};
                var b = {};
                for (var i = 0; i < a.length; ++i) {
                    var p=a[i].split('=', 2);
                    if (p.length == 1)
                        b[p[0]] = "";
                    else
                        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
                }
                return b;
            })(window.location.search.substr(1).split('&'));
            return qs
        },
        reset(state) {
            let sub = Object.keys(state).filter(x => state[x])
            this.extensions = sub.map(x => Extensions[x])
            this.resetkey++
        },
        onselect(id) {
            this.current = id
        },
        timezoned() {
            var offset = new Date().getTimezoneOffset();
            var minutes = Math.abs(offset);
            var hours = Math.floor(minutes / 60);
            var prefix = offset < 0 ? "" : "-";
            return parseInt(prefix+hours);
        },
        // New data handler. Should return Promise, or
        // use callback: load_chunk(range, tf, callback)
        async load_chunk(range) {
            let [t1, t2] = range
            let x = symbolbg
            let y = pairbg
            let q = `${x}${y}&interval=1m&startTime=${t1}&endTime=${t2}`
            let r = await fetch(URL + q).then(r => r.json())
            return this.format(this.parse_binance(r))
        },
        // Parse a specific exchange format
        parse_binance(data) {
            if (!Array.isArray(data)) return []
            return data.map(x => {
                for (var i = 0; i < x.length; i++) {
                    x[i] = parseFloat(x[i])
                }
                return x.slice(0,6)
            })
        },
        format(data) {
            return {
                'chart.data': data,
            }
        },
        on_trades(trade) {
            this.dc.update({
                t: trade.T,     // Exchange time (optional)
                price: parseFloat(trade.p),   // Trade price
                volume: parseFloat(trade.q),  // Trade amount
                datas : [ // Update dataset
                    trade.T,
                    trade.m ? 0 : 1,          // Sell or Buy
                    parseFloat(trade.q),
                    parseFloat(trade.p)
                ],
                // ... other onchart/offchart updates
            })
        }
    }
}
</script>

<style>
.app-content {
    padding: calc(2rem + 2.45rem) 0 0 0rem !important;
    overflow-x: hidden;
}
@media (max-width: 767.98px){
    html body.navbar-sticky .app-content {
        padding: calc(1rem - 0.8rem + 4.45rem) 0 0 0 !important;
    }
}
.flexed {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    align-content: center;
    flex-wrap: nowrap;
}

#app-conainer {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-content: space-between;
    align-items: flex-start;
    flex-wrap: nowrap;
}

/* @media (max-width: 767.98px){
    #app-conainer {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-content: space-between;
        align-items: flex-start;
        flex-wrap: nowrap;
    }
} */
#tradebar {
    color: #ddd;
}

#tvjs-header {
    position: absolute;
    display: flex;
    align-content: center;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: flex-start;
    align-items: center;
    padding-left: 70px;
    height: 40px;
    color: #ddd;
    width: 100%;
    background-color: #121826;
}

.night-mode {
    position: absolute;
    top: 15px;
    right: 20px;
}

#trading-vue-js-grid-0-canvas,
#trading-vue-js-sidebar-0-canvas,
#trading-vue-js-grid-1-canvas,
#trading-vue-js-sidebar-1-canvas,
#trading-vue-js-botbar-canvas {
    background-color: rgb(0 0 0 / 0%) !important;
}

#trading-vue-tbitem {
    background-color: rgb(18, 24, 38);
}

@media only screen and (max-device-width: 480px) {
    .tf-selector {
        top: 50px;
        right: 140px;
        max-width: 140px;
        font: 12px -apple-system, BlinkMacSystemFont,
            Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell,
            Fira Sans, Droid Sans, Helvetica Neue,
            sans-serif;
    }
}

.box {
    width: 280px;
    margin: 0 auto;
    box-shadow: 0 1.5px 5px -2px rgba(0, 0, 0, 0.2);
    border-radius: 3px;
    padding: 0 15px 0 15px;
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

td .percent {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
}

.newest {
    border-bottom: 1px solid #eee;
    margin: 15px -15px;
}

.card-110 {
    top: 110px !important;
    left: 70px;
}
/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
    transition: margin-left .5s;
    /* If you want a transition effect */
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
    .sidebar1 {
        padding-top: 15px;
    }

    .sidebar1 a {
        font-size: 18px;
    }
}

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    font-size: 8px;
    text-align: center;
}

#chartdiv {
    min-height: 300px;
    max-height: 400px;
    height: 70vh;
}
</style>
