<template>
    <div>
        <div v-for="c in coinsList" :key="c.symbol" class="card" :class="c.style">
            <a :href="'/'+urll+c.token+'/USDT'" class="stretched-link"></a>
            <!-- <a id="bookmarked" data-bs-toggle="modal" data-bs-target="#deleteWatchlist" name="{{$watchlist->id}}">
                            <i class="bi bi-bookmark-fill position-absolute top-0 end-0 me-1 mt-1 bookmarked fs-4"></i></a>
                            @if (Request::is('**/real*'))
                        <a href="/user/real/{{ $watchlist['symbol'] }}">
                    @else
                        <a href="/user/demo/{{ $watchlist['symbol'] }}">
                    @endif -->
                    <a id="bookmarked" class="btn-close bg-white text-danger position-absolute top-0 start-100 translate-middle " data-bs-toggle="modal" data-bs-target="#deleteWatchlist" :name="c.token"></a>

            <div class="main-grid-info flex-row flex-top flex-stretch row">
                <div class="col-2">
                    <img class="avatar avatar-icon" style="margin-top:3px;" width="36" height="36" :src="c.icon"
                        :alt="c.pair">
                </div>
                <div class="col-10 flex-1 shadow-text">
                    <div class="row">
                        <div class="col text-start text-clip">
                            <h1 class="text-warning fs-5 text-clip">
                                {{ c.token }}
                            </h1>
                            <!-- <small class="text-faded text-condense">/{{ c.asset }}</small> -->
                            <h2 class="text-bright fs-5">
                                {{ c.close | toFixed( asset ) }}
                            </h2>
                        </div>
                        <div class="col text-end">
                            <div class="color fs-6 text-clip">
                                {{ c.arrow }} {{ c.sign }}{{ c.percent | toFixed( 2 ) }}%
                            </div>
                            <div class="text-clip fs-6">
                                {{ c.sign }}{{ c.change | toFixed( asset ) }} <small class="text-faded">24h</small>
                            </div>
                            <div class="text-clip fs-6">
                                {{ c.assetVolume | toMoney }} <small class="text-faded">Vol</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-grid-chart">
                <linechart :width="600" :height="40" :values="c.history" />
            </div>
        </div>
    </div>
</template>

<script>

import txt from 'raw-loader!../resources/assets/cors.txt';
export default {
    name: 'Watchlist',
    // app data
        data: function() {
            return {
                endpoint : txt+'wss://stream.binance.com:9443/ws/!ticker@arr',
                urll     : '',
                cache    : {},             // coins data cache
                coins    : [],             // live coin list from api
                watched    : [],             // live coin list from api
                asset    : 'USDT',          // filter by base asset pair
                sort     : 'assetVolume',  // sort by param
                order    : 'desc',         // sort order ( asc, desc )
                limit    : 10,             // limit list
                status   : 0,              // socket status ( 0: closed, 1: open, 2: active, -1: error )
                sock     : null,           // socket inst
                cx       : 0,
                cy       : 0,
            };
        },
        // computed methods
        computed: {

            // process coins list
            coinsList() {
            let list = this.coins.slice();

            if ( this.asset ) {
                list = list.filter( i => i.asset === this.asset );
            }
            if ( this.sort ) {
                list = this.sortList( list, this.sort, this.order );
            }
            if ( this.limit ) {
                list = list.slice( 0, this.limit );
            }
            return list;
            },

            // sort-by label for buttons, etc
            sortLabel() {
            switch ( this.sort ) {
                case 'token'       :  return 'Token';
                case 'percent'     :  return 'Percent';
                case 'close'       :  return 'Price';
                case 'change'      :  return 'Change';
                case 'assetVolume' :  return 'Volume';
                case 'tokenVolume' :  return 'Volume';
                case 'trades'      :  return 'Trades';
                default            :  return 'Default';
            }
            },
        },
        // app mounted
        mounted() {
            this.sockInit();
            this.updateurll();
        },

        // app destroyed
        destroyed() {
            this.sockClose();
        },

        // custom methods
        methods: {
            updateurll() {
                if(document.location.pathname.indexOf('**/practice*') == 0) {
                    this.urll = 'user/practice/';
                } else if(document.location.pathname.indexOf('**/trade*') == 0) {
                    this.urll = 'user/trade/';
                } else if(document.location.pathname.indexOf('**/exchange*') == 0) {
                    this.urll = 'user/exchange/';
                } else {
                    this.urll = 'user/practice/';
                }
            },
            // apply sorting and toggle order
            sortBy( key, order ) {
            if ( this.sort !== key ) { this.order = order || 'asc'; }
            else { this.order = ( this.order === 'asc' ) ? 'desc' : 'asc'; }
            this.sort = key;
            },

            // filter by asset
            filterAsset( asset ) {
            this.asset = String( asset || 'BTC' );
            },

            // set list limit
            setLimit( limit ) {
            this.limit = parseInt( limit ) || 0;
            },

            // on socket connected
            onSockOpen( e ) {
            this.status = 1; // open
            },

            // on socket closed
            onSockClose( e ) {
            this.status = 0; // closed
            setTimeout( this.sockInit, 10000 ); // try again
            },

            // on socket error
            onSockError( err ) {
            this.status = -1; // error
            setTimeout( this.sockInit, 10000 ); // try again
            },

            // process data from socket
            onSockData( e ) {
            let list = JSON.parse( e.data ) || [];

            for ( let item of list ) {
                // cleanup data for each coin
                let c = this.getCoinData( item );
                // keep to up 100 previous close prices in hostiry for each coin
                c.history = this.cache.hasOwnProperty( c.symbol ) ? this.cache[ c.symbol ].history : this.fakeHistory( c.close );
                if ( c.history.length > 100 ) c.history = c.history.slice( c.history.length - 100 );
                c.history.push( c.close );
                // add coin data to cache
                this.cache[ c.symbol ] = c;
            }
            // convert cache object to final prices list for each symbol
            this.coins = Object.keys( this.cache ).map( s => this.cache[ s ] );
            this.status = 2; // active
            },

            // start socket connection
            sockInit() {
            if ( this.status > 0 ) return;
            try {
                this.status = 0; // closed
                this.sock = new WebSocket( this.endpoint );
                this.sock.addEventListener( 'open', this.onSockOpen );
                this.sock.addEventListener( 'close', this.onSockClose );
                this.sock.addEventListener( 'error', this.onSockError );
                this.sock.addEventListener( 'message', this.onSockData );
            }
            catch( err ) {
                this.status = -1; // error
                this.sock = null;
            }
            },

            // start socket connection
            sockClose() {
                if ( this.sock ) {
                    this.sock.close();
                }
            },

            // come up with some fake history prices to fill in the initial line chart
            fakeHistory( close ) {
            let num = close * 0.0001; // faction of current price
            let min = -Math.abs( num );
            let max = Math.abs( num );
            let out = [];

            for ( let i = 0; i < 50; ++i ) {
                let rand = Math.random() * ( max - min ) + min;
                out.push( close + rand );
            }
            return out;
            },

            // finalize data for each coin from socket
            getCoinData( item ) {
            let reg2         = new RegExp('^('+document.getElementById('watched').classList+')(USDT)$');
            let symbol      = String( item.s ).replace( /[^\w\-]+/g, '' ).toUpperCase();
            let token       = symbol.replace( reg2, '$1' );
            let asset       = symbol.replace( reg2, '$2' );
            let name        = token;
            let pair        = token +'/'+ asset;
            let icon        = '/assets/images/cryptoCurrency/'+ token.toLowerCase() + '.png';
            let open        = parseFloat( item.o );
            let high        = parseFloat( item.h );
            let low         = parseFloat( item.l );
            let close       = parseFloat( item.c );
            let change      = parseFloat( item.p );
            let percent     = parseFloat( item.P );
            let trades      = parseInt( item.n );
            let tokenVolume = Math.round( item.v );
            let assetVolume = Math.round( item.q );
            let sign        = ( percent >= 0 ) ? '+' : '';
            let arrow       = ( percent >= 0 ) ? '▲' : '▼';
            let info        = [ pair, close.toFixed( 8 ), '(', arrow, sign + percent.toFixed( 2 ) +'%', '|', sign + change.toFixed( 8 ), ')' ].join( ' ' );
            let style       = '';

            if ( percent > 0 ) style = 'gain';
            if ( percent < 0 ) style = 'loss';

            return { symbol, token, asset, name, pair, icon, open, high, low, close, change, percent, trades, tokenVolume, assetVolume, sign, arrow, style, info };
            },

            // sort an array by key and order
            sortList( list, key, order ) {
            return list.sort( ( a, b ) => {
                let _a = a[ key ];
                let _b = b[ key ];

                if ( _a && _b ) {
                _a = ( typeof _a === 'string' ) ? _a.toUpperCase() : _a;
                _b = ( typeof _b === 'string' ) ? _b.toUpperCase() : _b;

                if ( order === 'asc' ) {
                    if ( _a < _b ) return -1;
                    if ( _a > _b ) return 1;
                }
                if ( order === 'desc' ) {
                    if ( _a > _b ) return -1;
                    if ( _a < _b ) return 1;
                }
                }
                return 0;
            });
            },
        },
}
</script>
<style>
hr {
  display: block;
  overflow: hidden;
  margin: 1em 0;
  height: 0;
  border: 0;
  border-bottom: 2px solid rgba(255, 255, 255, 0.04);
}

.if-small {
  display: none;
}
@media only screen and (min-width : 420px) {
  .if-small {
    display: initial;
  }
}

.if-medium {
  display: none;
}
@media only screen and (min-width : 720px) {
  .if-medium {
    display: initial;
  }
}

.if-large {
  display: none;
}
@media only screen and (min-width : 1200px) {
  .if-large {
    display: initial;
  }
}

.hidden, [hidden], [v-cloak] {
  display: none;
}

.disabled, [disabled] {
  pointer-events: none;
  opacity: 0.5;
}

.push-top {
  margin-top: 1em;
}

. {
  margin-right: 1em;
}

.push-bottom {
  margin-bottom: 1em;
}

.push-left {
  margin-left: 1em;
}

.push-all {
  margin: 1em;
}

.pad-top {
  padding-top: 1em;
}

.pad-right {
  padding-right: 1em;
}

.pad-bottom {
  padding-bottom: 1em;
}

.pad-left {
  padding-left: 1em;
}

.pad-all {
  padding: 1em;
}

.border-top {
  border-top: 2px solid rgba(255, 255, 255, 0.04);
}

.border-right {
  border-right: 2px solid rgba(255, 255, 255, 0.04);
}

.border-bottom {
  border-bottom: 2px solid rgba(255, 255, 255, 0.04);
}

.border-left {
  border-left: 2px solid rgba(255, 255, 255, 0.04);
}

.flex-row {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
}

.flex-wrap {
  flex-wrap: wrap;
}

.flex-left {
  justify-content: flex-start;
}

.flex-center {
  justify-content: center;
}

.flex-right {
  justify-content: flex-end;
}

.flex-space {
  justify-content: space-between;
}

.flex-around {
  justify-content: space-around;
}

.flex-top {
  align-items: flex-start;
}

.flex-middle {
  align-items: center;
}

.flex-bottom {
  align-items: flex-end;
}

.flex-1 {
  flex: 1;
}

.flex-2 {
  flex: 2;
}

.flex-3 {
  flex: 3;
}

.flex-4 {
  flex: 4;
}

.flex-5 {
  flex: 5;
}

.text-left {
  text-align: left;
}

.text-right {
  text-align: right;
}

.text-center {
  text-align: center;
}

.text-justify {
  text-align: justify;
}

.text-uppercase {
  text-transform: uppercase;
}

.text-lowercase {
  text-transform: lowercase;
}

.text-capitalize {
  text-transform: capitalize;
}

.text-underline {
  text-decoration: underline;
}

.text-striked {
  text-decoration: line-through;
}

.text-italic {
  font-style: italic;
}

.text-bold {
  font-weight: bold;
}

.text-nowrap {
  white-space: nowrap;
}

.text-clip {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.text-primary {
  color: orange;
}

.text-secondary {
  color: #20acea;
}

.text-grey {
  color: #5c6776;
}

.text-bright {
  color: #f0f0f0;
}

.text-faded {
  color: white;
  opacity: 0.3;
}

.text-small {
  font-size: 70%;
  line-height: 1.14em;
}

.text-condense {
  letter-spacing: -1px;
}

.shadow-box {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.shadow-text {
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.main-wrap {
  position: relative;
  padding: calc( 4em + 1em ) 1em 1em 1em;
}
{
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  grid-gap: 1em;
}
@media only screen and (min-width : 420px) {
  {
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  }
}

.card.gain {
  background-color: #222a22;
}
.card.gain polyline.color {
  stroke: limegreen;
}
.card.gain circle.color {
  fill: limegreen;
}
.card.gain .color {
  color: limegreen;
}
.card.loss {
  background-color: #331a1f;
}
.card.loss polyline.color {
  stroke: crimson;
}
.card.loss circle.color {
  fill: crimson;
}
.card.loss .color {
  color: crimson;
}
.card .main-grid-info {
  padding: 1em;
}
.card .main-grid-chart {
  padding: 1em;
  background-image: radial-gradient(ellipse at top right, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0) 60%);
}
</style>
