<template>
    <span>
        <div class="multi-chart">
            <chartbox
v-for="(timeframe, id) in charts"
:id="id"
                :key="id"
:tf="id"
:data="timeframe"
                :width="cbox_width"
:height="cbox_height"
                :night="night"
:ext="ext"
:xsett="xsett"
                :resetkey="resetkey"
/>
        </div>
        <div
class="link-icon"
:style="lst"
@click="onlink"
/>
        <codepane
v-if="code"
:colors="colors"
:width="500"
        :height="500"
:src="rules"
        @src-changed="src_changed"
        @close-code="oncodeclose"
/>
    </span>
</template>
<script>

import TradingVue from 'trading-vue-js'
import { DataCube } from 'trading-vue-js'
import Data from '../../resources/data/data-multi.json'
import Chartbox from '../components/Chartbox.vue'
import Codepane from '../components/Codepane.vue'
import Utils from '../stuff/utils.js'
import Const from '../stuff/constants.js'
import Stream from '../stream.js'

// Gettin' data through webpeck proxy
const PORT = location.port
const URL = `http://localhost:${PORT}/api/v1/klines?symbol=`
const WSS = `ws://localhost:${PORT}/ws/btcusdt@aggTrade`

const DEFAULT = `// Chart link rules
{
    '*': {
        cursor: true,
        position: true,
        tools: true
    },
    'D -> 1H': {
        data: ['BB'], // WIP
    },
    'D -> 4H,12H': {
        range: 'X' // WIP
    },
    '1H -> *': {
        // ...
    }
}
`

export default {
    name: 'App1',
    components: {
        TradingVue, Chartbox, Codepane
    },
    props: ['night', 'ext', 'resetkey'],
    data() {
        return {
            charts: Data,
            width: window.innerWidth,
            height: window.innerHeight,
            xsett: {
                'grid-resize': { min_height: 30 },
                'chart-link': { rules: {} }
            },
            rules: DEFAULT,
            code: false
        }
    },
    computed: {
        cbox_width() { return Math.floor(this.width / 2 - 1) },
        cbox_height() { return Math.floor(this.height / 2 - 1) },
        colors() {
            return this.$props.night ? {} : {
                colorBack: '#fff',
                colorGrid: '#eee',
                colorText: '#333',
                cmBack: '#fffffff0',
                cmCode: '#333',
                selection: '#eeeeef99',
                cmLineNumber: '#6d8a8882',
                border: '#88888888',
                shadow: '#0b0e1422'
            }
        },
        lst() {
            return this.night ? { 'opacity': '0.6' } : {}
        }
    },
    mounted() {
        window.addEventListener('resize', this.onResize)
        this.onResize()
        this.src_changed(DEFAULT)
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
        onResize(event) {
            this.width = window.innerWidth
            this.height = window.innerHeight - 50
        },
        src_changed(txt) {
            this.rules = txt
            try {
                let code = txt.replace('{', 'return {')
                var obj = new Function('', `${code}`)()
            } catch(e) {
                console.log('SYNTAX ERR', {e})
                return
            }
            this.xsett['chart-link'].rules = obj
        },
        onlink() {
            this.code = true
        },
        oncodeclose() {
            this.code = false
        },
        // New data handler. Should return Promise, or
        // use callback: load_chunk(range, tf, callback)
        async load_chunk(range) {
            let [t1, t2] = range
            let x = 'BTCUSDT'
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
                'datasets.binance-btcusdt': [ // Update dataset
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
.multi-chart {
    display: grid;
    grid-template-columns: 50% 50%;
    height: 100%;
}
.link-icon {
    position: absolute;
    width: 25px;
    height: 25px;
    background: url(/assets/link.png);
    background-size: cover;
    top: calc(50% - 14px);
    left: calc(50% - 12px);
    cursor: pointer;
    z-index: 1000;
    opacity: 0.9;
}
</style>
