<template>
    <div class="px-0">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button
                    class="nav-link"
                    @click.prevent="setActive('pills-market')"
                    :class="{ active: isActive('pills-market') }"
                    href="#pills-market"
                >
                    Rise/Fall
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div
                class="tab-pane fade"
                :class="{ 'active show': isActive('pills-market') }"
                id="pills-market"
                role="tabpanel"
                aria-labelledby="pills-market-tab"
            >
                <form id="Order" @submit.prevent="Order()">
                    <div class="row pb-1 px-1">
                        <div class="col-6">
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Time</span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    :min="min_time"
                                    :max="max_time"
                                    required=""
                                    v-model="time"
                                    placeholder="Time"
                                />
                                <button
                                    class="btn btn-outline-secondary dropdown-toggle text-dark border-0"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ OrderTimeUnit }}
                                </button>
                                <ul
                                    class="dropdown-menu dropdown-menu-end"
                                    v-if="limit != null"
                                    :key="limit.max_time_hour"
                                >
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            @click="
                                                SetOrderTime(
                                                    'Sec',
                                                    limit.min_time_sec,
                                                    limit.max_time_sec
                                                )
                                            "
                                            >Sec</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            value="min"
                                            class="dropdown-item"
                                            @click="
                                                SetOrderTime(
                                                    'Min',
                                                    limit.min_time_min,
                                                    limit.max_time_sec
                                                )
                                            "
                                            >Min</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            value="hour"
                                            class="dropdown-item"
                                            @click="
                                                SetOrderTime(
                                                    'Hour',
                                                    limit.min_time_hour,
                                                    limit.max_time_hour
                                                )
                                            "
                                            >Hour</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Amount</span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    :min="limit.min_amount"
                                    :max="limit.max_amount"
                                    step="0.00000001"
                                    required=""
                                    v-model="amount"
                                    placeholder="Amount"
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div class="d-grid mt-1">
                                <button
                                    class="btn btn-success btn-sm"
                                    type="submit"
                                    :disabled="loading"
                                    @click="SetOrderType(1)"
                                >
                                    <i class="bi bi-graph-up"></i> Rise
                                </button>
                            </div>
                            <div class="pt-3 ordercard hidden">
                                <div class="clock"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-light"
                            >
                                <a v-if="type == 'practice'" class="text-light"
                                    >Practice Wallet</a
                                >
                                <a v-else class="text-light">Wallet</a>
                            </label>

                            <div
                                v-if="type == 'practice'"
                                class="input-group input-group-sm mb-1"
                            >
                                <input
                                    type="number"
                                    class="form-control text-white border-0"
                                    :key="user.practice_balance"
                                    :value="user.practice_balance"
                                    readonly
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-light border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div v-else class="input-group input-group-sm mb-1">
                                <input
                                    v-if="wallet !== null"
                                    type="number"
                                    class="form-control text-white border-0"
                                    :key="wallet"
                                    :value="wallet"
                                    readonly
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <form
                                    v-else
                                    @submit.prevent="createWallet(currency)"
                                >
                                    <button
                                        type="submit"
                                        class="btn btn-success btn-sm"
                                    >
                                        Create Wallet
                                    </button>
                                </form>
                                <span
                                    class="input-group-text text-light border-0"
                                    >{{ currency }}</span
                                >
                            </div>

                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-light"
                            >
                                <a class="text-light">Profit</a>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-white border-0"
                                    :value="gnl.profit | toMoney"
                                    readonly
                                />
                                <span
                                    class="input-group-text text-light border-0"
                                    >%</span
                                >
                            </div>
                            <div class="d-grid mt-1">
                                <button
                                    class="btn btn-danger btn-sm"
                                    type="submit"
                                    :disabled="loading"
                                    @click="SetOrderType(2)"
                                >
                                    <i class="bi bi-graph-down"></i> Fall
                                </button>
                            </div>
                            <div class="mt-3 ordercard hidden">
                                <div>
                                    <span class="text-warning"
                                        >Order Type: </span
                                    ><span class="tradeType"></span>
                                </div>
                                <div>
                                    <span class="text-warning">Price Was: </span
                                    ><span class="tradePrice"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Highcharts from "highcharts";
import stockInit from "highcharts/modules/stock";
import accessibility from "highcharts/modules/accessibility";

let tick = new WebSocket("wss://stream.binance.com:9443/ws");

// component
export default {
    props: ["symbol", "currency", "limit", "user", "type"],

    // component list
    components: {},
    // component data
    data() {
        return {
            activeItem: "pills-market",
            loading: false,
            gnl: gnl,
            time: null,
            amount: null,
            wallet: null,
            obj: [],
            min_time: this.limit.min_time_sec,
            max_time: this.limit.max_time_sec,
            tradeLogId: null,
            second: null,
            OrderTimeUnit: "Sec",
            OrderType: null,
            message: [],
            dataframe: {},
            timeCount: null,
        };
    },

    // custom methods
    methods: {
        SetOrderType(value) {
            this.OrderType = value;
        },
        SetOrderTime(time_unit, min, max) {
            this.OrderTimeUnit = time_unit;
            this.min_time = min;
            this.max_time = max;
        },
        secondCount() {
            if (this.OrderTimeUnit == "Sec") {
                return this.time;
            } else if (this.OrderTimeUnit == "Min") {
                return this.time * 60;
            } else if (this.OrderTimeUnit == "Hour") {
                return this.time * 60 * 60;
            }
        },
        fetchData() {
            this.$http
                .post("/user/fetch/binary/trade/wallet", {
                    currency: this.currency,
                })
                .then((response) => {
                    this.wallet = response.data.wallet;
                });
        },
        createWallet(symbol) {
            (this.loading = true),
                this.$http
                    .post("/user/wallet/j/create", {
                        type: "funding",
                        symbol: symbol,
                    })
                    .then((response) => {
                        this.fetchData(symbol);
                        this.$toast[response.data.type](response.data.message);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        },
        Order() {
            this.timeCount = this.secondCount();
            if (this.type == "practice") {
                if (this.user.practice_balance < this.amount) {
                    this.$toast.error(
                        "Your Practice Balance Not Enough! Please Add Practice Amount"
                    );
                } else if (isNaN(this.amount) || this.amount <= 0) {
                    this.$toast.error("Please Insert Valid Amount");
                } else if (isNaN(this.timeCount) || this.timeCount <= 0) {
                    this.$toast.error("Please Select Valid Time");
                } else {
                    this.loading = true;
                    $(".ordercard").removeClass("hidden");
                    tick.send(
                        JSON.stringify({
                            method: "SUBSCRIBE",
                            params: [
                                this.symbol.toLowerCase() +
                                    this.currency.toLowerCase() +
                                    "@miniTicker",
                            ],
                            id: 1,
                        })
                    );
                    let json = [];
                    const chart = new Highcharts.chart("Chart", {
                        chart: {
                            backgroundColor: "#22292F",
                            type: "spline",
                            animation: Highcharts.svg,
                            marginRight: 10,
                            events: {
                                load: function () {
                                    tick.onmessage = (tickEvent) => {
                                        this.message = JSON.parse(
                                            tickEvent.data
                                        );
                                        if (this.message.E != null) {
                                            let c = Number(this.message.c);
                                            let E = Number(this.message.E);
                                            this.dataframe = [E, c];
                                            chart.series[0].addPoint(
                                                this.dataframe,
                                                true
                                            );
                                            json.push({
                                                time: E,
                                                value: c,
                                            });
                                        }
                                    };
                                },
                            },
                        },
                        time: {
                            useUTC: false,
                        },
                        accessibility: {
                            announceNewData: {
                                enabled: true,
                                minAnnounceInterval: 15000,
                                announcementFormatter: function (
                                    allSeries,
                                    newSeries,
                                    newPoint
                                ) {
                                    if (newPoint) {
                                        return (
                                            "New point added. Value: " +
                                            newPoint.y
                                        );
                                    }
                                    return false;
                                },
                            },
                        },

                        title: {
                            text: this.symbol + "/" + this.currency,
                            style: {
                                color: "#fff",
                            },
                        },
                        xAxis: {
                            type: "datetime",
                            tickPixelInterval: 150,
                            lineColor: "#fff",
                            tickColor: "#fff",
                            labels: {
                                style: {
                                    color: "#fff",
                                },
                            },
                            title: {
                                style: {
                                    color: "#fff",
                                },
                            },
                        },

                        yAxis: {
                            lineColor: "#fff",
                            tickColor: "#fff",
                            labels: {
                                style: {
                                    color: "#fff",
                                },
                            },
                            title: {
                                text: "Price",
                                style: {
                                    color: "#fff",
                                },
                            },
                            plotLines: [
                                {
                                    value: 0,
                                    width: 1,
                                    color: "#fff",
                                },
                            ],
                        },

                        tooltip: {
                            headerFormat: "<b>{point.y:.2f}</b><br/>",
                            pointFormat: "{point.x:%Y-%m-%d %H:%M:%S}<br/>",
                        },

                        legend: {
                            enabled: false,
                        },

                        exporting: {
                            enabled: false,
                        },
                        series: [
                            {
                                boostThreshold: 1,
                            },
                        ],
                        credits: {
                            enabled: false,
                        },
                    });
                    this.obj = json;
                    this.placeOrder();
                }
            } else if (this.type == "trade") {
                if (this.wallet < this.amount) {
                    this.$toast.error(
                        "Your Balance Not Enough! Please Add Balance First"
                    );
                } else if (isNaN(this.amount) || this.amount <= 0) {
                    this.$toast.error("Please Insert Valid Amount");
                } else if (isNaN(this.timeCount) || this.timeCount <= 0) {
                    this.$toast.error("Please Select Valid Time");
                } else {
                    this.loading = true;
                    $(".ordercard").removeClass("hidden");
                    tick.send(
                        JSON.stringify({
                            method: "SUBSCRIBE",
                            params: [
                                this.symbol.toLowerCase() +
                                    this.currency.toLowerCase() +
                                    "@miniTicker",
                            ],
                            id: 1,
                        })
                    );
                    let json = [];
                    const chart = new Highcharts.chart("Chart", {
                        chart: {
                            backgroundColor: "#22292F",
                            type: "spline",
                            animation: Highcharts.svg,
                            marginRight: 10,
                            events: {
                                load: function () {
                                    tick.onmessage = (tickEvent) => {
                                        this.message = JSON.parse(
                                            tickEvent.data
                                        );
                                        if (this.message.E != null) {
                                            let c = Number(this.message.c);
                                            let E = Number(this.message.E);
                                            this.dataframe = [E, c];
                                            chart.series[0].addPoint(
                                                this.dataframe,
                                                true
                                            );
                                            json.push({
                                                time: E,
                                                value: c,
                                            });
                                        }
                                    };
                                },
                            },
                        },
                        time: {
                            useUTC: false,
                        },
                        accessibility: {
                            announceNewData: {
                                enabled: true,
                                minAnnounceInterval: 15000,
                                announcementFormatter: function (
                                    allSeries,
                                    newSeries,
                                    newPoint
                                ) {
                                    if (newPoint) {
                                        return (
                                            "New point added. Value: " +
                                            newPoint.y
                                        );
                                    }
                                    return false;
                                },
                            },
                        },

                        title: {
                            text: this.symbol + "/" + this.currency,
                            style: {
                                color: "#fff",
                            },
                        },
                        xAxis: {
                            type: "datetime",
                            tickPixelInterval: 150,
                            lineColor: "#fff",
                            tickColor: "#fff",
                            labels: {
                                style: {
                                    color: "#fff",
                                },
                            },
                            title: {
                                style: {
                                    color: "#fff",
                                },
                            },
                        },

                        yAxis: {
                            lineColor: "#fff",
                            tickColor: "#fff",
                            labels: {
                                style: {
                                    color: "#fff",
                                },
                            },
                            title: {
                                text: "Price",
                                style: {
                                    color: "#fff",
                                },
                            },
                            plotLines: [
                                {
                                    value: 0,
                                    width: 1,
                                    color: "#fff",
                                },
                            ],
                        },

                        tooltip: {
                            headerFormat: "<b>{point.y:.2f}</b><br/>",
                            pointFormat: "{point.x:%Y-%m-%d %H:%M:%S}<br/>",
                        },

                        legend: {
                            enabled: false,
                        },

                        exporting: {
                            enabled: false,
                        },
                        series: [
                            {
                                boostThreshold: 1,
                            },
                        ],
                        credits: {
                            enabled: false,
                        },
                    });
                    this.obj = json;
                    this.placeOrder();
                }
            }
        },
        placeOrder() {
            this.$http
                .post("/user/binary/" + this.type + "/store", {
                    amount: this.amount,
                    symbol: this.symbol,
                    OrderType: this.OrderType,
                    duration: this.time,
                    currency: this.currency,
                    unit: this.OrderTimeUnit,
                })
                .then((response) => {
                    if (response.data.value == 1) {
                        this.tradeLogId = response.data.tradeLogId;
                        this.countDown(this.timeCount);
                        if (this.OrderType == 1) {
                            $(".tradeType").text("Rise");
                            $(".tradePrice").text(
                                response.data.trade + " " + this.currency
                            );
                            this.$toast.success("Trade: Rise");
                        } else {
                            $(".tradeType").text("Fall");
                            $(".tradePrice").text(
                                response.data.trade + " " + this.currency
                            );
                            this.$toast.success("Trade: Fall");
                        }
                    } else if (response.data.value == 2) {
                        this.$toast.error(response.data.message);
                    } else {
                        $.each(response, function (i, val) {
                            this.$toast.error(val);
                        });
                    }
                })
                .catch((error) => {})
                .finally(() => {
                    this.loading = false;
                });
        },
        countDown(timeCount) {
            var clock = $(".clock").FlipClock({
                clockFace: "MinuteCounter",
                language: "en",
                autoStart: false,
                countdown: true,
                showSeconds: true,
                callbacks: {
                    stop: () => {
                        this.gameResult();
                    },
                },
            });
            clock.setTime(timeCount - 1);
            clock.setCountdown(true);
            clock.start();
        },
        gameResult() {
            this.$http
                .post("/user/binary/" + this.type + "/result", {
                    tradeLogId: this.tradeLogId,
                    currency: this.currency,
                    obj: this.obj,
                })
                .then((response) => {
                    if (response.data == 1) {
                        this.$toast.success("Trade Win");
                    } else if (response.data == 2) {
                        this.$toast.error("Trade Lose");
                    } else if (response.data == 3) {
                        this.$toast.error("Trade Draw");
                    } else {
                        $.each(response.data, function (i, val) {
                            this.$toast.error(val);
                        });
                    }
                    this.$emit("Ordered", response.data.balance);
                })
                .catch((error) => {})
                .finally(() => {
                    this.loading = false;
                    tick.send(
                        JSON.stringify({
                            method: "UNSUBSCRIBE",
                            params: [
                                this.symbol.toLowerCase() +
                                    this.currency.toLowerCase() +
                                    "@miniTicker",
                            ],
                            id: 1,
                        })
                    );
                    setTimeout(function () {
                        $("#Chart").highcharts().destroy();
                        $(".ordercard").addClass("hidden");
                    }, 1000);
                    if (this.type == "trade") {
                        this.fetchData();
                    }
                });
        },
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
        clean() {
            $("#Chart").highcharts().destroy();
            $(".ordercard").addClass("hidden");
        },
    },

    // on component created
    created() {
        if (this.type == "trade") {
            this.fetchData();
        }
        let flipclock = document.createElement("script");
        flipclock.setAttribute(
            "src",
            "https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.js"
        );
        document.head.appendChild(flipclock);
    },

    // on component mounted
    mounted() {
        stockInit(Highcharts);
        accessibility(Highcharts);
    },

    // on component destroyed
    destroyed() {},
};
</script>
<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.7/flipclock.min.css";
</style>
