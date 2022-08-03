<template>
    <div class="app-wrap" style="margin: -28px">
        <!-- topbar with logo and menu -->
        <Topbar
            :header="header"
            :options="options"
            :tickerStatus="tickerStatus"
            :tickerTime="tickerTime"
            :priceData="priceData"
            :historyData="historyData"
            :alarmsData="alarmsData"
            :newsEntries="newsEntries"
        >
        </Topbar>

        <!-- price watch form -->
        <WatchForm
            :header="header"
            :options="options"
            :tickerStatus="tickerStatus"
            :assetsList="assetsList"
            :marketsData="marketsData"
            :priceData="priceData"
        >
        </WatchForm>

        <!-- main app pages wrapper -->
        <div class="app-main">
            <keep-alive>
                <main
                    class="page-wrap"
                    :class="{
                        collapsed: header.collapsed,
                        opaque: header.opaque,
                    }"
                >
                    <div class="card-body" style="padding: 10px">
                        <!-- fixed list search/sorting controls -->
                        <section class="page-topbar">
                            <div class="flex-row flex-middle flex-space">
                                <!-- control search -->
                                <Search
                                    class="light"
                                    v-model="searchStr"
                                ></Search>

                                <!-- control heading -->
                                <div
                                    class="flex-1 text-clip text-big text-center me-1 if-medium"
                                >
                                    24h Change
                                </div>

                                <!-- control dropdown menus -->
                                <div
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-secondary bi bi-chevron-down iconLeft"
                                            id="Limitmenu"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            {{ limitCountLabel }}
                                        </button>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="Limitmenu"
                                        >
                                            <li class="heading px-1">
                                                <span class="form-label"
                                                    >Limits</span
                                                >
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeLimit(10),
                                                }"
                                                @click="limitList(10)"
                                            >
                                                <i
                                                    class="bi bi-list-ul iconLeft"
                                                ></i>
                                                10 tokens
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeLimit(20),
                                                }"
                                                @click="limitList(20)"
                                            >
                                                <i
                                                    class="bi bi-list-ul iconLeft"
                                                ></i>
                                                20 tokens
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeLimit(50),
                                                }"
                                                @click="limitList(50)"
                                            >
                                                <i
                                                    class="bi bi-list-ul iconLeft"
                                                ></i>
                                                50 tokens
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeLimit(100),
                                                }"
                                                @click="limitList(100)"
                                            >
                                                <i
                                                    class="bi bi-list-ul iconLeft"
                                                ></i>
                                                100 tokens
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeLimit(0),
                                                }"
                                                @click="limitList(0)"
                                            >
                                                <i
                                                    class="bi bi-list-ul iconLeft"
                                                ></i>
                                                All tokens
                                            </li>
                                        </div>
                                    </div>
                                    &nbsp;

                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-secondary iconLeft"
                                            id="Sortingmenu"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i class="bi bi-sort-down-alt"></i>
                                            {{ sortByLabel }}
                                        </button>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="Sortingmenu"
                                        >
                                            <li class="heading px-1">
                                                <span class="form-label"
                                                    >Sorting Options</span
                                                >
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort('token'),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'token',
                                                        'asc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-coin iconLeft"
                                                ></i>
                                                Token
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'percent'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'percent',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-percent iconLeft"
                                                ></i>
                                                Percent
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort('close'),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'close',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-graph-up iconLeft"
                                                ></i>
                                                Price
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'volatility'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'volatility',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-graph-up iconLeft"
                                                ></i>
                                                Volatility
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'danger'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'danger',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-exclamation-circle iconLeft"
                                                ></i>
                                                Danger
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'change'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'change',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-clock iconLeft"
                                                ></i>
                                                Change
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'marketVolume'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'marketVolume',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-bar-chart-line-fill iconLeft"
                                                ></i>
                                                Volume
                                            </li>
                                            <li
                                                class="dropdown-item clickable"
                                                :class="{
                                                    active: activeSort(
                                                        'trades'
                                                    ),
                                                }"
                                                @click="
                                                    $sorter.sortOrder(
                                                        'ticker',
                                                        'trades',
                                                        'desc'
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-arrow-left-right iconLeft"
                                                ></i>
                                                Trades
                                            </li>
                                        </div>
                                    </div>
                                    &nbsp;

                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-warning bi bi-star iconLeft"
                                            v-text="options.prices.market"
                                            id="Filtermenu"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        ></button>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="Filtermenu"
                                        >
                                            <div class="px-1 mb-1">
                                                <span class="form-label"
                                                    >Filter by Market</span
                                                >
                                            </div>
                                            <div class="tablelist-wrap">
                                                <div class="tablelist-content">
                                                    <div
                                                        class="tablelist-row flex-row flex-middle flex-stretch clickable"
                                                        v-for="m of marketsData"
                                                        :key="m.token"
                                                        :class="{
                                                            active: activeMarket(
                                                                m.token
                                                            ),
                                                        }"
                                                        @click="
                                                            toggleMarket(
                                                                m.token
                                                            )
                                                        "
                                                    >
                                                        <div class="flex-1">
                                                            <i
                                                                class="bi bi-star iconLeft"
                                                            ></i>
                                                            {{ m.token }}
                                                        </div>
                                                        <div class="ps-1">
                                                            {{ m.count }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    &nbsp;

                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-warning bi bi-gear"
                                            id="Livemenu"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        ></button>
                                        <div
                                            class="dropdown-menu px-1"
                                            aria-labelledby="Livemenu"
                                        >
                                            <div
                                                class="form-label mb-1 push-small"
                                            >
                                                Live Price Options
                                            </div>
                                            <Toggle
                                                :text="'Show top coins price in header'"
                                                v-model="options.prices.header"
                                                @change="saveOptions"
                                            ></Toggle>
                                            <Toggle
                                                :text="'Show price chart for in list'"
                                                v-model="options.prices.chart"
                                                @change="saveOptions"
                                            ></Toggle>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- empty list message -->
                        <section class="mb-1" v-if="!listCount">
                            <div
                                class="card p-1 flex-row flex-middle flex-stretch"
                            >
                                <div
                                    class="bi bi-info-circle iconLarge me-1"
                                ></div>
                                <div class="text-clip flex-1">
                                    <div v-if="searchStr">
                                        <span class="text-dark"
                                            >No match for
                                            <span class="text-secondary">{{
                                                searchStr
                                            }}</span></span
                                        >
                                        <br />
                                        <span class="text-info"
                                            >Can't find anything matching your
                                            search input.</span
                                        >
                                    </div>
                                    <div v-else>
                                        <span class="text-dark"
                                            >No price data available</span
                                        >
                                        <br />
                                        <span class="text-info"
                                            >Price data from remote API has not
                                            loaded yet.</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- live ticker price list -->
                        <section class="pagelist-wrap">
                            <div
                                class="pagelist-item flex-row flex-middle flex-stretch shadow"
                                style="background: rgb(255 255 255 / 6%)"
                                v-if="tickerList.length"
                            >
                                <div class="iconWidth me-1 if-small"></div>
                                <div class="me-1 text-clip flex-1">
                                    <span
                                        class="clickable"
                                        @click="
                                            $sorter.sortOrder(
                                                'ticker',
                                                'token',
                                                'asc'
                                            )
                                        "
                                        >Token</span
                                    >
                                </div>
                                <div class="me-1 text-clip flex-1">
                                    <span
                                        class="clickable"
                                        @click="
                                            $sorter.sortOrder(
                                                'ticker',
                                                'close',
                                                'desc'
                                            )
                                        "
                                        >Price</span
                                    >
                                </div>
                                <div
                                    class="well me-1 flex-1 if-medium disabled"
                                    v-if="options.prices.chart"
                                ></div>
                                <div class="me-1 text-clip flex-1">
                                    <span
                                        class="clickable"
                                        @click="
                                            $sorter.sortOrder(
                                                'ticker',
                                                'percent',
                                                'desc'
                                            )
                                        "
                                        >Percent</span
                                    >
                                </div>
                                <div class="me-1 text-clip flex-1 if-medium">
                                    <span
                                        class="clickable"
                                        @click="
                                            $sorter.sortOrder(
                                                'ticker',
                                                'marketVolume',
                                                'desc'
                                            )
                                        "
                                        >Volume</span
                                    >
                                </div>
                                <div class="text-end text-clip flex-1 if-large">
                                    <span
                                        class="clickable"
                                        @click="
                                            $sorter.sortOrder(
                                                'ticker',
                                                'trades',
                                                'desc'
                                            )
                                        "
                                        >Book</span
                                    >
                                </div>
                            </div>

                            <div
                                v-for="p in tickerList"
                                class="pagelist-item flex-row flex-middle flex-stretch clickable shadow"
                                :class="p.style"
                                @click="showPair(p.route)"
                                :key="p.symbol"
                            >
                                <div
                                    class="me-1 if-small"
                                    :class="{ 'alarm-bubble': p.alarms }"
                                >
                                    <TokenIcon
                                        :image="p.image"
                                        :alt="p.token"
                                    ></TokenIcon>
                                </div>

                                <div class="me-1 text-clip flex-1">
                                    <big class="text-warning">{{
                                        p.token
                                    }}</big>
                                    <br />
                                    <span class="text-secondary">{{
                                        p.name
                                    }}</span>
                                </div>

                                <div
                                    class="me-1 text-clip flex-1"
                                    style="margin-left: -45px"
                                >
                                    <big class="text-nowrap text-dark fw-bold"
                                        >{{ p.close | toFixed(p.market) }}
                                        <span class="text-secondary">{{
                                            p.market
                                        }}</span></big
                                    >
                                    <br />
                                    <span class="text-nowrap color fw-bold"
                                        >{{ p.sign
                                        }}{{ p.change | toFixed(p.market) }}
                                        <span class="text-secondary"
                                            >24H</span
                                        ></span
                                    >
                                </div>

                                <div
                                    class="well me-1 flex-1 if-medium"
                                    v-if="options.prices.chart"
                                >
                                    <LineChart
                                        :width="200"
                                        :height="28"
                                        :values="p.history"
                                    ></LineChart>
                                </div>

                                <div class="me-1 text-clip flex-1">
                                    <big class="text-nowrap color fw-bold"
                                        >{{ p.sign
                                        }}{{ p.percent | toMoney(3) }}%</big
                                    >
                                    <br />
                                    <span
                                        class="bi bi-bar-chart"
                                        title="High/Low Volatility Score"
                                        v-tooltip
                                    >
                                        {{ p.volatility | toFixed(3) }}</span
                                    >
                                </div>

                                <div class="me-1 text-clip flex-1 if-medium">
                                    <big class="text-nowrap text-dark fw-bold"
                                        >{{ p.marketVolume | toMoney }}
                                        <span
                                            class="text-nowrap text-secondary"
                                            >{{ p.market }}</span
                                        ></big
                                    >
                                    <br />
                                    <span class="text-nowrap text-secondary"
                                        >{{ p.tokenVolume | toMoney }}
                                        <span
                                            class="text-nowrap text-secondary"
                                            >{{ p.token }}</span
                                        ></span
                                    >
                                </div>

                                <div class="text-end text-clip flex-1 if-large">
                                    <big
                                        class="text-nowrap text-dark fw-bold"
                                        >{{ p.trades | toMoney }}</big
                                    >
                                    <br />
                                    <button
                                        class="text-primary-hover"
                                        :title="'Trade ' + p.token"
                                        v-tooltip
                                    >
                                        Trades
                                    </button>
                                </div>
                            </div>

                            <!-- if there are more items not included in list due to limit option -->
                            <div
                                class="pagelist-item flex-row flex-middle flex-space shadow"
                                style="background: rgb(255 255 255 / 6%)"
                                v-if="listCount"
                            >
                                <div class="text-secondary bi bi-list iconLeft">
                                    {{ listLeftText }}
                                </div>
                                <button
                                    v-if="listLeft"
                                    class="text-dark bi bi-list-ul iconLeft"
                                    @click="limitList(0)"
                                >
                                    Show all
                                </button>
                            </div>
                        </section>

                        <!-- list spinner -->
                        <Spinner class="fixed" ref="spinner"></Spinner>
                    </div>
                </main>
            </keep-alive>
        </div>

        <!-- common modal component -->
        <Modal ref="modal" @onDone="modalDone">
            <component
                :is="modalComp"
                :options="options"
                :sortData="sortData"
                :modalData="modalData"
                :historyData="historyData"
                :alarmsData="alarmsData"
                :newsEntries="newsEntries"
            >
            </component>
        </Modal>

        <!-- common notification component -->
        <Notify ref="notify"> </Notify>
    </div>
</template>

<style lang="scss">
@import "../scss/variables";
@import "../scss/mixins";
@import "../scss/reset";
@import "../scss/common";
@import "../scss/animations";
@import "../scss/flexbox";
@import "../scss/emoji";
@import "../scss/type";
@import "../scss/forms";
@import "../scss/prompt";
@import "../scss/tooltip";
@import "../scss/modifiers";
</style>

<script>
import Topbar from "../components/market/Topbar.vue";
import Modal from "../components/market/Modal.vue";
import Notify from "../components/market/Notify.vue";
import WatchForm from "../components/market/WatchForm.vue";
import OptionsPage from "../components/market/OptionsPage.vue";
import OptionsPageAdmin from "../components/market/OptionsPageAdmin.vue";
import HistoryPage from "../components/market/HistoryPage.vue";
import AlarmsList from "../components/market/AlarmsList.vue";
import TokenPage from "../components/market/TokenPage.vue";
import Spinner from "../components/market//Spinner.vue";
import Search from "../components/market//Search.vue";
import TokenIcon from "../components/market//TokenIcon.vue";
import Dropdown from "../components/market//Dropdown.vue";
import Toggle from "../components/market//Toggle.vue";
import LineChart from "../components/market//LineChart.vue";

// component
export default {
    // component list
    components: {
        Topbar,
        Modal,
        Notify,
        WatchForm,
        //AboutPage,
        OptionsPage,
        OptionsPageAdmin,
        HistoryPage,
        AlarmsList,
        //NewsPage,
        //TradePage,
        TokenPage,
        Spinner,
        Search,
        TokenIcon,
        Dropdown,
        Toggle,
        LineChart,
    },

    // component data
    data() {
        return {
            refid: "12268078",
            title: "",
            // app options and data
            options: {},
            sortData: {},
            priceData: [],
            assetsList: [],
            newsHandlers: [],
            newsEntries: [],
            historyData: [],
            alarmsData: [],
            quoteSymbols: [],
            marketsData: {},
            coinsData: {},
            // page and modal related
            mainComp: "",
            modalComp: "",
            modalData: {},
            // ticker related data
            tickerStatus: 0, // ( 0: off, 1: wait, 2: on )
            tickerStart: 0,
            tickerTime: "",
            searchStr: "",
            listCount: 0,
            listLeft: 0,
            // fixed header props
            header: {
                collapsed: false,
                opaque: false,
            },
        };
    },

    // computed methods
    computed: {
        // get filtered and sorted ticker list for display
        tickerList() {
            let { market } = this.options.prices;
            let { column, order } = this.sortData.ticker;

            let limit = parseInt(this.options.prices.limit) | 0;
            let search = String(this.searchStr).replace(/[^A-Z0-9]+/gi, "");
            let regex = search.length > 1 ? new RegExp(search, "i") : null;
            let count = this.priceData.length;
            let list = [];

            // filter the list
            while (count--) {
                let p = this.priceData[count];
                if (market && p.market !== market) continue;
                if (regex && !(regex.test(p.token) || regex.test(p.name)))
                    continue;
                list.push(p);
            }
            // sort the list
            list = this.$utils.sort(list, column, order);

            // update paging totals
            let total = list.length;
            this.listCount = total;
            this.listLeft = 0;

            // trim the list
            if (total && limit && limit < total) {
                list = list.slice(0, limit);
                this.listLeft = total - list.length;
            }
            return list;
        },

        // sort-by label for buttons, etc
        sortByLabel() {
            let { column } = this.sortData.ticker;
            switch (column) {
                case "token":
                    return "Token";
                case "percent":
                    return "Percent";
                case "close":
                    return "Price";
                case "volatility":
                    return "Volatility";
                case "danger":
                    return "Danger";
                case "change":
                    return "Change";
                case "marketVolume":
                    return "Volume";
                case "tokenVolume":
                    return "Volume";
                case "trades":
                    return "Trades";
                default:
                    return "Default";
            }
        },

        // text to show in limit filter controls
        limitCountLabel() {
            let limit = parseInt(this.options.prices.limit) | 0;
            if (limit && limit < this.listCount)
                return limit + "/" + this.listCount;
            return "All " + this.listCount;
        },

        // text about hidden list pair
        listLeftText() {
            let total = this.listCount;
            let remain = this.listLeft;
            let market = this.options.prices.market;
            let limit = this.options.prices.limit;
            let count = this.$utils.noun(
                total,
                market + " token pair",
                market + " token pairs"
            );
            if (remain) return "Showing " + limit + " of " + count;
            return "Showing all " + count;
        },
    },

    // watch methods
    watch: {
        priceData() {
            this.updateSpinner();
        },
        tickerStatus() {
            this.updateSpinner();
        },
    },
    // custom methods
    methods: {
        // check if key is active sort option
        activeSort(column) {
            return this.sortData.ticker.column === column;
        },

        // check if num is active list limit option
        activeLimit(limit) {
            return this.options.prices.limit === limit;
        },

        // check if market is active selected market
        activeMarket(market) {
            return this.options.prices.market === market;
        },

        // apply options
        saveOptions() {
            this.$opts.saveOptions(this.options);
        },

        // set app url route

        /*Link() {
      let { token, market } = this.modalData;
      //this.$bus.emit( 'handleClick', '/user/trade/'+ token +'_'+ market +'/', '_blank' );
        if (window.location.href.indexOf("practice") > -1) {
            window.open("/user/practice/" + token, "_self")
        } else {
            window.open("/user/trade/" + token, "_self")
        }
    },*/

        // set list limit value
        limitList(num) {
            this.options.prices.limit = parseInt(num) | 0;
            this.saveOptions();
        },

        // filter by asset
        toggleMarket(market) {
            this.options.prices.market = String(market || "USDT");
            this.saveOptions();
        },

        // update page spinner
        updateSpinner() {
            if (!this.$refs.spinner) return;
            if (this.tickerList.length) return this.$refs.spinner.hide();
            if (this.tickerStatus === 0)
                return this.$refs.spinner.error("Market socket not connected");
            if (this.tickerStatus === 1)
                return this.$refs.spinner.show("Waiting for market price data");
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        // update app options and pass it on to other handlers
        updateOptions(options) {
            this.options = options;

            this.$ajax.setOptions({
                proxy: this.options.proxy,
            });
            this.$notify.setOptions({
                enabled: this.options.notify.enabled,
                duration: this.options.notify.duration,
                sound: this.options.audio.enabled,
                volume: this.options.audio.volume,
                audio: this.options.audio.file,
            });
            this.$news.setOptions({
                enabled: this.options.news.enabled,
                interval: this.options.news.interval,
                delay: this.options.news.delay,
                days: this.options.news.days,
                tweets: this.options.news.tweets,
                total: this.options.news.total,
            });
            this.$messenger.setOptions({
                mailgin: this.options.mailgin,
                telegram: this.options.telegram,
            });
            this.$binance.setApiKey(this.options.binance.apikey);
            this.$binance.setApiSecret(this.options.binance.apisecret);
        },

        // setup options class handlers and load saved options
        setupOptionsHandlers() {
            this.$opts.on("update", this.updateOptions);
            this.$opts.loadOptions();
        },

        // setup sort order data handler
        setupSorterHandlers() {
            this.$sorter.setKey("ticker", "marketVolume", "desc");
            this.$sorter.setKey("sentiment", "count", "desc");
            this.$sorter.setKey("balances", "asset", "asc");
            this.$sorter.setKey("orders", "time", "desc");
            this.$sorter.setKey("trades", "time", "desc");
            this.$sorter.setKey("sessions", "time", "desc");
            this.$sorter.on("change", (data) => {
                this.sortData = data;
            });
            this.$sorter.on("load", (data) => {
                this.sortData = data;
            });
            this.$sorter.loadData();
        },

        // setup app routes
        setupRoutes() {
            // page routes
            this.$router.on("/market", () => {
                this.showPage("TokenList", "Price List");
            });
            //this.$router.on( '/news', () => { this.showPage( 'NewsPage', 'Twitter News' ) } );
            //this.$router.on( '/trade', () => { this.showPage( 'TradePage', 'Trade Bot' ) } );
            // modal routes
            this.$router.on("/market/history", () => {
                this.showModal("HistoryPage", "Recent Alert History");
            });
            this.$router.on("/market/alarms", () => {
                this.showModal("AlarmsList", "Saved Price Alarms");
            });
            //this.$router.on( '/about', () => { this.showModal( 'AboutPage', 'About This App' ) } );
            this.$router.on("/market/options", () => {
                this.showModal("OptionsPage", "Options & Settings");
            });
            this.$router.on("/market/optionsadmin", () => {
                this.showModal("OptionsPageAdmin", "Admin Options & Settings");
            });
            // symbol modal route
            this.$router.on("/market/symbol/([A-Z0-9]+)", (symbol) => {
                let d = this.priceData
                    .filter((p) => p.symbol === symbol)
                    .shift();
                if (d) return this.showModal("TokenPage", d.pair + " Info ", d);
            });
        },

        // set a url hash route
        showPair(symbol) {
            let d = this.priceData.filter((p) => p.symbol === symbol).shift();
            if (d) return this.showModal("TokenPage", d.pair + " Info ", d);
        },

        // setup global event bus handlers
        setupGlobalHandlers() {
            this.$bus.on("setTitle", this.setTitle);
            this.$bus.on("showPair", this.showPair);
            this.$bus.on("showModal", this.showModal);
            this.$bus.on("closeModal", this.closeModal);
            this.$bus.on("showNotice", this.showNotice);
            this.$bus.on("handleClick", this.handleClick);
        },

        // setup alarms class handlers
        setupAlarmsHandlers() {
            this.$alarms.on("update", (data) => {
                this.alarmsData = data;
            });
            this.$alarms.loadData();
        },

        // setup history class handlers
        setupHistoryHandlers() {
            this.$history.on("update", (data) => {
                this.historyData = data;
            });
            this.$history.loadData();
        },

        // setup twitter news handlers
        setupNewsHandlers() {
            this.$news.useAjax(this.$ajax);
            this.$news.on("error", (err) => {
                console.warn(err);
            });
            this.$news.on("handlers", (data) => {
                this.newsHandlers = data;
            });
            this.$news.on("tweets", (data) => {
                this.newsEntries = data;
            });
        },

        // setup msg queue to go off on a timer
        setupMessengerHandlers() {
            this.$messenger.useAjax(this.$ajax);
            this.$messenger.on("sent", (info) => {
                this.showNotice(info, "info");
            });
            this.$messenger.start();
        },

        // setup scroller handlers
        setupScrollHandlers() {
            this.$scroller.on("scroll", (pos) => {
                this.onScrollChange("scroll", pos);
            });
            this.$scroller.on("down", (pos) => {
                this.onScrollChange("down", pos);
            });
            this.$scroller.on("up", (pos) => {
                this.onScrollChange("up", pos);
            });
        },

        // setup coincap data handlers
        setupCoincapHandlers() {
            this.$coincap.useAjax(this.$ajax);
            this.$coincap.on("allcoins", this.onCoincapData);
            this.$coincap.fetchAll();
        },

        // setup binance live ticker data handlers
        setupTickerHandlers() {
            this.$binance.useAjax(this.$ajax);
            this.$binance.on("sock_fail", this.onSockFail);
            this.$binance.on("ticker_init", this.onTickerInit);
            this.$binance.on("ticker_fail", this.onTickerFail);
            this.$binance.on("ticker_error", this.onTickerError);
            this.$binance.on("ticker_close", this.onTickerClose);
            this.$binance.on("ticker_open", this.onTickerOpen);
            this.$binance.on("ticker_data", this.onTickerData);
            this.$binance.on("ticker_prices", this.onTickerPrices);
            this.$binance.on("markets_data", this.onMarketsData);
            this.$binance.fetchMarketsData();
            this.$binance.startTickerStream(true);
        },

        // handle coincap all coins data
        onCoincapData(coins) {
            this.coinsData = coins;
            this.$binance.setCoinData(coins);
        },

        // handle binance available markets data
        onMarketsData(markets) {
            const list = Object.keys(markets);
            this.assetsList = list;
            this.marketsData = markets;
        },

        // when scroll position updates
        onScrollChange(dir, pos) {
            if (dir === "scroll") {
                this.header.opaque = pos > 10;
            }
            if (dir === "down") {
                this.header.collapsed = true;
            }
            if (dir === "up") {
                this.header.collapsed = false;
            }
        },

        // show socket related notifications
        tickerNotify(title, message) {
            if (document.hasFocus()) return;
            let d = new Date();
            this.$notify.add(title, message + " \nNow: " + d.toLocaleString());
        },

        // on socket init fail
        onSockFail(error) {
            this.tickerStatus = 0;
            this.showNotice(error, "error");
        },

        // on socket conenction attempt
        onTickerInit(time) {
            this.tickerStatus = 0;
            this.tickerStart = time;
        },

        // on socket failure to start
        onTickerFail(error) {
            this.tickerStatus = 0;
            this.showNotice(error, "error");
        },

        // when socket connection ends
        onTickerError(e) {
            let info = String(
                e.message ||
                    "Your country in ban list, Please try using VPN to access our services."
            );
            this.tickerStatus = 0;
            this.tickerNotify("Ticker Error", info);
            this.showNotice(info, "error");
        },

        // when socket connection ends
        onTickerClose(e) {
            this.tickerStatus = 0;
            this.$bus.emit("toggleWatchform", "stop");
            this.$bus.emit("toggleTradeBot", "stop");
        },

        // when socket connection opens
        onTickerOpen(e) {
            this.tickerStatus = 1;
            this.tickerStart = Date.now();
        },

        // when socket connection has data
        onTickerData(data) {
            this.tickerStatus = 2;
        },

        // updates price data list from socket on an interval
        onTickerPrices(prices) {
            for (let i = 0; i < prices.length; ++i) {
                let p = prices[i];
                p.alarms = this.$alarms.getCount(p.symbol);
                this.updateModalPairData(p);
                this.checkPairAlarms(p);
            }
            let secs = (Date.now() - this.tickerStart) / 1000;
            this.tickerTime = this.$utils.elapsed(secs, "", true);
            this.priceData = prices;
        },

        // check if alarms need to go off for a pair
        checkPairAlarms(pair) {
            this.$alarms.check(pair.symbol, pair.close, (title, info, a) => {
                let icon = this.$utils.fullUrl(a.image);
                this.$notify.add(title, info, icon, (e) => {
                    this.setRoute("/history");
                });
                this.$messenger.add(title, info, icon);
                this.$history.add(title, info, icon);
            });
        },

        // build page title
        setTitle(info) {
            let title = String(info || "").trim();
            let list = [this.title];
            if (title) list.unshift(title);
            document.title = list.join(" ");
        },

        // handler for click events passed through the event bus
        handleClick() {
            let args = Array.from(arguments);
            let action = args.length ? args.shift() : "";
            let dest = args.length ? args.shift() : "";
            let target = args.length ? args.shift() : "_blank";

            if (action === "scroll") return this.$scroller.jumpTo(dest);
            if (action === "link") return window.open(dest, target);
            if (action === "reload") return window.location.reload();
            if (action === "return") return window.history.back();

            if (action === "binance") {
                let symb = /\?/g.test(dest) ? "&" : "?";
                let base =
                    "https://www.binance.com" +
                    dest +
                    symb +
                    "ref=" +
                    this.refid;
                return window.open(base, target);
            }
        },

        // show modal window
        showModal(component, title, data) {
            if (!this.$refs.modal) return;
            title = title || component;
            this.setTitle(title);
            this.modalComp = component;
            this.modalData = data;
            this.$refs.modal.show(title);
        },

        // update pair data inside modals
        updateModalPairData(pair) {
            if (!this.modalData || !this.modalData.symbol) return;
            if (!pair || !pair.symbol || this.modalData.symbol !== pair.symbol)
                return;
            this.modalData = pair;
        },

        // close modal window, if open
        closeModal() {
            if (!this.$refs.modal) return;
            this.$refs.modal.close();
        },

        // on modal close event
        modalDone() {
            this.modalComp = "";
            this.modalData = {};
        },

        // show css alert
        showNotice(message, type, timeout) {
            if (!this.$refs.notify) return;
            this.$refs.notify.show(message, type, timeout);
        },

        // fetch wordlist files for sentiment analysis
        fetchSentimentWords() {
            Array("words").forEach((file) => {
                this.$ajax.get("../../market/afinn/" + file + ".json", {
                    type: "json",
                    proxy: false,
                    success: (xhr, status, words) =>
                        this.$sentiment.merge(words),
                });
            });
        },

        // hide initial page spinner
        hideInitSpinner() {
            const spinner = document.querySelector("#_spnr");
            if (spinner) spinner.style.display = "none";
        },
    },

    // on component created
    created() {
        this.setupOptionsHandlers();
        this.setupSorterHandlers();
        this.setupGlobalHandlers();
        this.setupAlarmsHandlers();
        this.setupHistoryHandlers();
        this.setupNewsHandlers();
        this.setupMessengerHandlers();
        this.setupScrollHandlers();
        this.setupCoincapHandlers();
        this.setupTickerHandlers();
    },

    // on component mounted
    mounted() {
        this.updateSpinner();
        this.fetchSentimentWords();
        this.hideInitSpinner();
    },

    // on component destroyed
    destroyed() {
        this.$binance.stopTickerStream();
        this.$news.stopTimer();
    },
};
</script>

<style lang="scss">
@import "../scss/variables";
.pagelist-item-chart {
    padding: 0.5em;
    background-image: radial-gradient(
        ellipse at top right,
        rgba(#000, 0.2) 0%,
        rgba(#000, 0) 100%
    );
    border-radius: $lineJoin;
}
</style>
