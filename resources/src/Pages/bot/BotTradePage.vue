<template>
    <div style="margin: -27px -27px 0 -27px">
        <grid-layout
            :layout.sync="layout"
            :responsive-layouts="layouts"
            :col-num="12"
            :row-height="50"
            :is-draggable="draggable"
            :is-resizable="resizable"
            :vertical-compact="true"
            :use-css-transforms="true"
            :responsive="responsive"
        >
            <grid-item
                :x="layout[0].x"
                :y="layout[0].y"
                :w="layout[0].w"
                :h="layout[0].h"
                :i="layout[0].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked tabbable rounded shadow"
                style="overflow-y: auto; overflow-x: hidden"
            >
                <Markets
                    v-once
                    v-if="pairs != null"
                    :pairs="pairs"
                    :type="type"
                    :provider="provider"
                />
                <span class="vue-draggable-handle"></span>
            </grid-item>
            <grid-item
                :x="layout[1].x"
                :y="layout[1].y"
                :w="layout[1].w"
                :h="layout[1].h"
                :i="layout[1].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked tabbable rounded shadow"
                style="overflow-y: auto; overflow-x: hidden"
            >
                <Trades
                    v-if="symbol != null"
                    :symbol="symbol"
                    :currency="currency"
                    :runningBot="runningBot"
                    :key="runningBot"
                />
                <span class="vue-draggable-handle"></span>
            </grid-item>
            <grid-item
                :x="layout[2].x"
                :y="layout[2].y"
                :w="layout[2].w"
                :h="layout[2].h"
                :i="layout[2].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked rounded shadow"
            >
                <Marketinfo
                    v-if="provider != null"
                    :symbol="symbol"
                    :currency="currency"
                    :provider="provider"
                />
                <span class="vue-draggable-handle"></span>
            </grid-item>
            <grid-item
                :x="layout[3].x"
                :y="layout[3].y"
                :w="layout[3].w"
                :h="layout[3].h"
                :i="layout[3].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked rounded shadow"
            >
                <Tradingview
                    v-if="provide != null"
                    :key="symbol + currency"
                    :symbol="symbol"
                    :currency="currency"
                    :provide="provide"
                />
                <span class="vue-draggable-handle"></span>
            </grid-item>
            <grid-item
                :x="layout[4].x"
                :y="layout[4].y"
                :w="layout[4].w"
                :h="layout[4].h"
                :i="layout[4].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked rounded shadow"
            >
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
                                            for="selectBot"
                                            class="form-label d-flex justify-content-between text-1 text-dark"
                                        >
                                            <span>Bots</span>
                                        </label>
                                        <div>
                                            <button
                                                type="button"
                                                class="w-100 btn btn-primary mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#botTypeModal"
                                                ref="selectBot"
                                            >
                                                Select Bot
                                            </button>
                                        </div>
                                        <label
                                            v-if="bot_times != null"
                                            for="botTimed"
                                            class="form-label d-flex justify-content-between text-1 text-dark"
                                        >
                                            <span>Duration</span>
                                        </label>
                                        <div
                                            class="dropdown"
                                            v-if="bot_times != null"
                                        >
                                            <button
                                                class="w-100 btn btn-outline-warning dropdown-toggle mb-1"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                                ref="botTimed"
                                                name="botTimed"
                                            >
                                                Duration
                                            </button>
                                            <ul
                                                class="dropdown-menu dropdown-menu-end"
                                            >
                                                <li
                                                    v-for="(
                                                        timing, index
                                                    ) in bot_times"
                                                    :key="index"
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        @click="
                                                            setTiming(
                                                                timing.duration,
                                                                timing.type
                                                            )
                                                        "
                                                        >{{ timing.duration }}
                                                        {{ timing.type }}s</a
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                        <label
                                            for="botTimed"
                                            class="form-label d-flex justify-content-between text-1 text-dark"
                                        >
                                            <span>Launch</span>
                                        </label>
                                        <button
                                            class="w-100 btn btn-success d-flex align-items-center justify-content-between"
                                            type="submit"
                                            :disabled="loading"
                                        >
                                            <i
                                                class="bi bi-battery-charging fs-3"
                                            ></i
                                            ><span> Start Bot</span>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <label
                                            for="basic-url"
                                            class="form-label d-flex justify-content-between text-1 text-light"
                                        >
                                            <a class="text-light">Wallet</a>
                                        </label>
                                        <div class="input-group mb-1">
                                            <input
                                                v-if="balance !== null"
                                                type="number"
                                                class="form-control text-white border-0"
                                                :key="balance"
                                                :value="balance"
                                                readonly
                                                aria-label="Amount (to the nearest dollar)"
                                            />
                                            <form
                                                v-else
                                                @submit.prevent="createWallet()"
                                            >
                                                <button
                                                    type="submit"
                                                    class="btn btn-success w-100"
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
                                            for="Amount"
                                            class="form-label d-flex justify-content-between text-1 text-dark"
                                        >
                                            <span>Amount</span>
                                        </label>
                                        <div class="input-group mb-1">
                                            <input
                                                type="number"
                                                class="form-control text-dark border-0"
                                                :min="min_amount"
                                                :max="max_amount"
                                                :step="min_amount"
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <span class="vue-draggable-handle"></span>
            </grid-item>
            <grid-item
                :x="layout[5].x"
                :y="layout[5].y"
                :w="layout[5].w"
                :h="layout[5].h"
                :i="layout[5].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked rounded shadow"
            >
                <Orderbook
                    v-if="symbol != null"
                    :symbol="symbol"
                    :currency="currency"
                />
                <span class="vue-draggable-handle"></span>
            </grid-item>
        </grid-layout>

        <div
            class="modal fade"
            id="botTypeModal"
            tabindex="-1"
            aria-labelledby="botType"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body pb-3 px-sm-3">
                        <div
                            @click="setBot(bot)"
                            v-for="(bot, index) in bot_type"
                            :key="index"
                            style="stretched-link"
                        >
                            <div
                                class="row bg-wallet p-1 rounded mb-1"
                                :class="bot.id == 1 ? 'bg-wallet-active' : ''"
                            >
                                <div class="col-3">
                                    <img
                                        :src="
                                            bot.image
                                                ? 'assets/images/bot/' +
                                                  bot.image
                                                : '/market/notification.png'
                                        "
                                    />
                                </div>
                                <div class="col-9">
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-bold fs-4 text-white">
                                            {{ bot.title }}
                                            <span
                                                v-if="bot.is_new == 1"
                                                class="fs-6 badge bg-success text-white"
                                                >New</span
                                            >
                                        </div>
                                        <div
                                            class="fs-6 text-white d-none d-md-block"
                                        >
                                            <i class="bi bi-app-indicator"></i>
                                            {{ bot.fake }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <small class="fs-6 text-warning">{{
                                            bot.desc
                                        }}</small>
                                        <div>
                                            Highest APR Today:
                                            <span class="text-success"
                                                >{{ bot.perc }}%</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GridLayout, GridItem } from "vue-grid-layout";
import Marketinfo from "../../components/trading/Marketinfo.vue";
import Tradingview from "../../components/trading/Tradingview.vue";
import Orderbook from "../../components/trading/Orderbook.vue";
import Markets from "../../components/trading/Markets.vue";
import Trades from "../../components/bot/Trades.vue";

let testLayouts = {
    xs: [
        { x: 0, y: 17, w: 2, h: 7, i: "0" }, // Markets
        { x: 0, y: 13, w: 2, h: 7, i: "1" }, // Trades
        { x: 0, y: 0, w: 6, h: 1, i: "2" }, // Marketinfo
        { x: 0, y: 1, w: 4, h: 6, i: "3" }, // Tradingview
        { x: 0, y: 7, w: 4, h: 6, i: "4" }, // Order
        { x: 2, y: 13, w: 2, h: 14, i: "5" }, // Orderbook
    ],
    sm: [
        { x: 0, y: 16, w: 3, h: 8, i: "0" }, // Markets
        { x: 3, y: 16, w: 3, h: 8, i: "1" }, // Trades
        { x: 0, y: 0, w: 6, h: 2, i: "2" }, // Marketinfo
        { x: 0, y: 2, w: 4, h: 8, i: "3" }, // Tradingview
        { x: 0, y: 10, w: 4, h: 6, i: "4" }, // Order
        { x: 4, y: 2, w: 2, h: 14, i: "5" }, // Orderbook
    ],
    md: [
        { x: 0, y: 0, w: 3, h: 8, i: "0" }, // Markets
        { x: 0, y: 10, w: 3, h: 8, i: "1" }, // Trades
        { x: 3, y: 0, w: 7, h: 2, i: "2" }, // Marketinfo
        { x: 3, y: 2, w: 5, h: 8, i: "3" }, // Tradingview
        { x: 3, y: 10, w: 5, h: 6, i: "4" }, // Order
        { x: 8, y: 4, w: 2, h: 14, i: "5" }, // Orderbook
    ],
    lg: [
        { x: 0, y: 0, w: 3, h: 8, i: "0" }, // Markets
        { x: 0, y: 10, w: 3, h: 8, i: "1" }, // Trades
        { x: 3, y: 0, w: 6, h: 2, i: "2" }, // Marketinfo
        { x: 3, y: 2, w: 6, h: 8, i: "3" }, // Tradingview
        { x: 3, y: 10, w: 6, h: 6, i: "4" }, // Order
        { x: 9, y: 0, w: 3, h: 16, i: "5" }, // Orderbook
    ],
};

export default {
    props: ["user"],
    // component list
    components: {
        Marketinfo,
        Tradingview,
        Orderbook,
        Markets,
        Trades,
        GridLayout,
        GridItem,
    },

    // component data
    data() {
        return {
            symbol: this.$route.params.symbol,
            currency: this.$route.params.currency,
            activeItem: "pills-market",
            pairs: null,
            provider: null,
            provide: null,
            limit: null,
            gnl: gnl,
            layouts: testLayouts,
            layout: testLayouts["lg"],
            draggable: true,
            resizable: true,
            responsive: true,
            bot_timing: null,
            bot_times: null,
            bot_type: null,
            runningBot: null,
            loading: false,
            timing: null,
            amount: null,
            balance: null,
            bot_id: null,
            type: null,
            min_amount: null,
            max_amount: null,
        };
    },
    watch: {
        eventLog: function () {
            const eventsDiv = this.$refs.eventsDiv;
            eventsDiv.scrollTop = eventsDiv.scrollHeight;
        },
        $route(to, from) {
            window.location.reload();
        },
    },

    // custom methods
    methods: {
        Order() {
            this.$http
                .post("/user/store/bot", {
                    amount: this.amount,
                    botTime: this.timing,
                    bot_id: this.bot_id,
                    currency: this.currency,
                    symbol: this.symbol,
                    type: this.type,
                })
                .then((response) => {
                    this.$toast[response.data.type](response.data.message);
                    this.fetchData();
                    this.fetchWallet();
                })
                .catch((error) => {})
                .finally(() => {
                    this.loading = false;
                });
        },
        setBot(bot) {
            this.$refs.selectBot.innerText = bot.title;
            this.bot_id = bot.id;
            var times = [];
            this.bot_timing.forEach((timing) => {
                if (timing.bot_id === bot.id) {
                    times.push(timing);
                }
            });
            this.bot_times = times;
            this.min_amount = bot.limits.min_bot_amount;
            this.max_amount = bot.limits.max_bot_amount;
            $("#botTypeModal").modal("hide");
        },
        setTiming(duration, type) {
            if (duration != 1) {
                this.$refs.botTimed.innerText = duration + " " + type + "s";
            } else {
                this.$refs.botTimed.innerText = duration + " " + type;
            }
            this.type = type;
            this.timing = duration;
        },
        fetchWallet() {
            this.$http
                .post("/user/fetch/wallet", {
                    type: "funding",
                    symbol: this.currency,
                })
                .then((response) => {
                    this.balance = response.data.balance;
                });
        },
        createWallet() {
            (this.loading = true),
                this.$http
                    .post("/user/wallet/j/create", {
                        type: "funding",
                        symbol: this.symbol,
                    })
                    .then((response) => {
                        this.fetchWallet();
                        this.$toast[response.data.type](response.data.message);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        },
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
        fetchData() {
            this.$http
                .post("/user/fetch/bot/info", {
                    symbol: this.$route.params.symbol,
                    currency: this.$route.params.currency,
                })
                .then((response) => {
                    (this.provider = response.data.provider),
                        (this.bot_timing = response.data.bot_timing),
                        (this.bot_type = response.data.bot_type),
                        (this.runningBot = response.data.runningBot),
                        (this.provide = response.data.provide),
                        (this.pairs = response.data.pairs),
                        (this.limit = response.data.limit);
                });
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
    },

    created() {
        this.fetchData();
        this.fetchWallet();
    },
    mounted() {
        /*const plugin = document.createElement("script");
        plugin.setAttribute(
            "src",
            "/vendors/js/ccxt.js"
        );
        plugin.async = true;
        document.head.appendChild(plugin);*/
        window.addEventListener("hashchange", (e) => {
            this.fetchData();
        });
        window.addEventListener("load", (e) => {
            this.fetchData();
        });
    },
    // on component destroyed
    destroyed() {},
};
</script>
<style lang="scss" scope>
$dark: #171b29;
$light: #d5f0e9;
$ease-out-expo: cubic-bezier(0.005, 1, 0.22, 1);

:root {
    --theme-background-base: #{lighten($dark, 0%)};
    --theme-background-300: #{lighten($dark, 75%)};
    --theme-background-o75: #{rgba(lighten($dark, 10%), 0.75)};
    --theme-background-o20: #{rgba(lighten($dark, 10%), 0.2)};
    --theme-color-o75: #{rgba($light, 0.75)};
}

table {
    border-collapse: collapse;
    width: 100%;
    font-size: 11px;
    font-weight: 500;
    color: #b7bdc6;
    overflow: hidden;
    width: 100%;
}
.tdd {
    position: relative;
    height: 18px;
    line-height: 18px;
}
td {
    height: 12px;
    line-height: 12px;
    span {
        position: relative;
        z-index: 2;
    }
    .percent {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
    }
}
td.price {
    width: 30%;
    span {
        padding-left: 5px;
    }
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
table.asks {
    .percent {
        background-color: rgba(246, 70, 94, 0.2);
    }
}
table.bids {
    .percent {
        background-color: rgba(14, 203, 129, 0.2);
    }
}
table.asks_only {
    .percent {
        background-color: rgba(246, 70, 94, 0.2);
    }
}
table.bids_only {
    .percent {
        background-color: rgba(14, 203, 129, 0.2);
    }
}
.order-loader {
    position: relative;
    right: 0px;
    top: 120px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: #000000b5;
}
.se-pre-con2 {
    position: absolute;
    top: 50%;
    left: 50%;
}
.hidden {
    display: none;
}
@media (max-width: 767.98px) {
    html {
        body.navbar-sticky {
            .app-content {
                padding: calc(1rem - 0.8rem + 4.45rem) 0 0 0 !important;
            }
        }
    }
}
</style>
