<template>
    <trading-vue
:key="resetkey"
ref="tvjs"
:data="dc"
        :width="width"
        :height="height"
        :title-txt="title"
        color-title="#ff9f43"
        :legend-buttons="['display', 'settings', 'up', 'down', 'add', 'remove']"
        :chart-config="{DEFAULT_LEN:70,MIN_ZOOM:1}"
        :toolbar="true"
        :color-back="colors.colorBack"
        :color-grid="colors.colorGrid"
        :color-text="colors.colorText"
        :extensions="ext"
        :overlays="ovs"
        :x-settings="xsett"
        :timezone="timezone"
    />
</template>
<script>

import { TradingVue, DataCube } from 'trading-vue-js'
import Overlays from 'tvjs-overlays'
import Data from '../../resources/data/data.json'
import Utils from '../stuff/utils.js'
import Const from '../stuff/constants.js'
import Stream from '../stream.js'

// Gettin' data through webpeck proxy
const URL = `https://api.binance.com/api/v1/klines?symbol=`
const symbolsm = window.location.pathname.toLowerCase().split('/')[3]+'usdt'
const symbolbg = window.location.pathname.toUpperCase().split('/')[3]+'USDT'
const WSS = `wss://stream.binance.com:9443/ws/${symbolsm}@aggTrade`
const datas = `datasets.binance-${symbolsm}`

export default {
    name: 'App1',
    components: {
        TradingVue
    },
    props: ['night', 'ext', 'resetkey'],
    data() {
        return {
            dc: new DataCube(Data),
            title: symbolbg,
            width: window.innerWidth,
            height: window.innerHeight,
            log_scale: true,
            index_based: true,
            timezone: this.timezoned(),
            xsett: {
                'grid-resize': { min_height: 30 }
            },
            ovs: Object.values(Overlays)
        }
    },
    computed: {
        colors() {
            return this.$props.night ? {} : {
                colorBack: '#fff',
                colorGrid: '#eee',
                colorText: '#333'
            }
        },
    },
    mounted() {
        window.addEventListener('resize', this.onResize)
        this.onResize()
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
            this.width = window.innerWidth * 0.68
            this.height = window.innerHeight - 150
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
            let q = `${x}&interval=1m&startTime=${t1}&endTime=${t2}`
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
            // Each query sets data to a corresponding overlay
            return {
                'chart.data': data,
                // other onchart/offchart overlays can be added here,
                // but we are using Script Engine to calculate some:
                // see EMAx6 & BuySellBalance
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

</style>
