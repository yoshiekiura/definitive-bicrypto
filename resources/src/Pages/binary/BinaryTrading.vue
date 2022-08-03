<template>
    <div class="trading-page">
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
                <Order
                    v-if="gnl != null && limit != null"
                    :symbol="symbol"
                    :currency="currency"
                    :limit="limit"
                    :user="user"
                    :gnl="gnl"
                    :type="type"
                    :key="symbol + currency"
                    @Ordered="
                        fetchOrders();
                        fetchData();
                    "
                />
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
            <grid-item
                :x="layout[6].x"
                :y="layout[6].y"
                :w="layout[6].w"
                :h="layout[6].h"
                :i="layout[6].i"
                drag-allow-from=".vue-draggable-handle"
                drag-ignore-from=".no-drag"
                class="darked rounded shadow"
            >
                <ul class="nav nav-tabs" id="orders-tab" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            @click.prevent="setActive('open-orders')"
                            :class="{ active: isActive('open-orders') }"
                            href="#open-orders"
                            >Open Orders</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            @click.prevent="setActive('closed-orders')"
                            :class="{ active: isActive('closed-orders') }"
                            href="#closed-orders"
                            >Order History</a
                        >
                    </li>
                </ul>

                <div class="tab-content" id="orders-tabContent">
                    <div
                        class="tab-pane fade"
                        :class="{ 'active show': isActive('open-orders') }"
                        id="open-orders"
                        role="tabpanel"
                    >
                        <!-- <div class="table-responsive">
                    <table class="table text-dark table-sm table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">TxHash</th>
                                <th scope="col">Date</th>
                                <th scope="col">Pair</th>
                                <th scope="col">Side</th>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Filled</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(order, index) in orders.open"
                                :key="index"
                            >
                                <td data-label="TxHash" class="text-uppercase">
                                    {{ order.order_id }}
                                </td>
                                <td data-label="Date" class="text-uppercase">
                                    {{
                                        order.created_at
                                            | moment("dddd, MMMM Do YYYY")
                                    }}
                                </td>
                                <td data-label="Pair" class="text-uppercase">
                                    {{ order.symbol }}
                                </td>
                                <td data-label="Side" class="text-uppercase">
                                    <span
                                        v-if="order.side == 'buy'"
                                        class="fw-bold text-success"
                                        >Buy</span
                                    >
                                    <span v-else class="fw-bold text-danger"
                                        >Sell</span
                                    >
                                </td>
                                <td data-label="Price">
                                    {{ order.price }} {{ order.pair }}
                                </td>
                                <td data-label="Amount">
                                    {{ order.amount }} {{ symbol }}
                                </td>
                                <td data-label="Filled">
                                    {{ order.filled }} {{ symbol }}
                                </td>
                                <td data-label="Status">
                                    <span
                                        v-if="order.status == 'open'"
                                        class="badge bg-primary"
                                        >Live</span
                                    >
                                    <span
                                        v-else-if="order.status == 'filling'"
                                        class="badge bg-warning"
                                        >Filling</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>-->

                        <div class="ordercard hidden">
                            <div id="Chart"></div>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    :class="{ 'active show': isActive('closed-orders') }"
                    id="closed-orders"
                    role="tabpanel"
                >
                    <div class="table-responsive">
                        <v-table
                            :data="orders"
                            :currentPage.sync="currentPage"
                            :pageSize="10"
                            @totalPagesChanged="totalPages = $event"
                            class="table text-dark table-sm table-borderless"
                        >
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="created_at" scope="col"
                                        >Date</v-th
                                    >
                                    <th scope="col">Pair</th>
                                    <th scope="col">Type</th>
                                    <v-th sortKey="amount" scope="col"
                                        >Amount</v-th
                                    >
                                    <th scope="col">Price Was</th>
                                    <th scope="col">Duration</th>
                                    <v-th sortKey="result" scope="col"
                                        >Result</v-th
                                    >
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{ displayData }">
                                <tr v-for="row in displayData" :key="row.id">
                                    <td
                                        data-label="Date"
                                        class="text-uppercase"
                                    >
                                        {{
                                            row.created_at
                                                | moment("dddd, MMMM Do YYYY")
                                        }}
                                    </td>
                                    <td
                                        data-label="Pair"
                                        class="text-uppercase"
                                    >
                                        {{ row.symbol }}
                                    </td>
                                    <td
                                        data-label="Type"
                                        class="text-uppercase"
                                    >
                                        <span
                                            v-if="row.hilow == '1'"
                                            class="fw-bold text-success"
                                            >Rise</span
                                        >
                                        <span v-else class="fw-bold text-danger"
                                            >Fall</span
                                        >
                                    </td>
                                    <td data-label="Amount">
                                        {{ row.amount | toMoney(4) }}
                                        {{ symbol }}
                                    </td>
                                    <td data-label="Price Was">
                                        {{ row.price_was | toMoney(4) }}
                                        {{ row.pair }}
                                    </td>
                                    <td data-label="Duration">
                                        <span
                                            v-if="
                                                row.duration > 60 &&
                                                row.duration < 3600
                                            "
                                        >
                                            {{ (row.duration / 60, 2) }}
                                            Min</span
                                        >
                                        <span v-else-if="row.duration > 3600">
                                            {{ (row.duration / 3600, 2) }}
                                            Hours</span
                                        >
                                        <span v-else>
                                            {{ row.duration }} Sec</span
                                        >
                                    </td>
                                    <td data-label="Result">
                                        <span
                                            v-if="row.result == 1"
                                            class="badge bg-success"
                                            >Win</span
                                        >
                                        <span
                                            v-else-if="row.result == 2"
                                            class="badge bg-danger"
                                            >Lose</span
                                        >
                                        <span
                                            v-else-if="row.result == 3"
                                            class="badge bg-warning"
                                            >Draw</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>

                        <div class="me-5 float-end">
                            <smart-pagination
                                :currentPage.sync="currentPage"
                                :totalPages="totalPages"
                            />
                        </div>
                    </div>
                </div>
                <span class="vue-draggable-handle"></span>
            </grid-item>
        </grid-layout>
    </div>
</template>

<script>
import { GridLayout, GridItem } from "vue-grid-layout";
import Marketinfo from "../../components/trading/Marketinfo.vue";
import Tradingview from "../../components/trading/Tradingview.vue";
import Orderbook from "../../components/trading/Orderbook.vue";
import Markets from "../../components/trading/Markets.vue";
import Order from "../../components/binary/trading/Order.vue";
import Trades from "../../components/binary/trading/Trades.vue";

let testLayouts = {
    xs: [
        { x: 0, y: 17, w: 2, h: 7, i: "0" }, // Markets
        { x: 0, y: 13, w: 2, h: 7, i: "1" }, // Trades
        { x: 0, y: 0, w: 6, h: 1, i: "2" }, // Marketinfo
        { x: 0, y: 1, w: 4, h: 6, i: "3" }, // Tradingview
        { x: 0, y: 7, w: 4, h: 6, i: "4" }, // Order
        { x: 2, y: 13, w: 2, h: 14, i: "5" }, // Orderbook
        { x: 0, y: 20, w: 6, h: 8, i: "6" }, // Orders
    ],
    sm: [
        { x: 0, y: 16, w: 3, h: 8, i: "0" }, // Markets
        { x: 3, y: 16, w: 3, h: 8, i: "1" }, // Trades
        { x: 0, y: 0, w: 6, h: 2, i: "2" }, // Marketinfo
        { x: 0, y: 2, w: 4, h: 8, i: "3" }, // Tradingview
        { x: 0, y: 10, w: 4, h: 6, i: "4" }, // Order
        { x: 4, y: 2, w: 2, h: 14, i: "5" }, // Orderbook
        { x: 0, y: 24, w: 6, h: 8, i: "6" }, // Orders
    ],
    md: [
        { x: 0, y: 0, w: 3, h: 8, i: "0" }, // Markets
        { x: 0, y: 10, w: 3, h: 8, i: "1" }, // Trades
        { x: 3, y: 0, w: 7, h: 2, i: "2" }, // Marketinfo
        { x: 3, y: 2, w: 5, h: 8, i: "3" }, // Tradingview
        { x: 3, y: 10, w: 5, h: 6, i: "4" }, // Order
        { x: 8, y: 4, w: 2, h: 14, i: "5" }, // Orderbook
        { x: 0, y: 18, w: 10, h: 8, i: "6" }, // Orders
    ],
    lg: [
        { x: 0, y: 0, w: 3, h: 8, i: "0" }, // Markets
        { x: 0, y: 10, w: 3, h: 8, i: "1" }, // Trades
        { x: 3, y: 0, w: 6, h: 2, i: "2" }, // Marketinfo
        { x: 3, y: 2, w: 6, h: 8, i: "3" }, // Tradingview
        { x: 3, y: 10, w: 6, h: 6, i: "4" }, // Order
        { x: 9, y: 0, w: 3, h: 16, i: "5" }, // Orderbook
        { x: 0, y: 18, w: 12, h: 8, i: "6" }, // Orders
    ],
};

export default {
    props: ["user"],
    // component list
    components: {
        Marketinfo,
        Tradingview,
        Order,
        Orderbook,
        Markets,
        Trades,
        GridLayout,
        GridItem,
    },

    // component data
    data() {
        return {
            type: this.$route.params.type,
            symbol: this.$route.params.symbol,
            currency: this.$route.params.currency,
            activeItem: "open-orders",
            orders: [],
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
            index: 0,
            currentPage: 1,
            totalPages: 0,
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
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
        fetchData() {
            this.$http
                .post(
                    "/user/fetch/binary/" +
                        this.$route.params.type +
                        "/" +
                        this.$route.params.symbol +
                        "/" +
                        this.$route.params.currency
                )
                .then((response) => {
                    (this.provider = response.data.provider),
                        (this.provide = response.data.provide),
                        (this.pairs = response.data.pairs),
                        (this.limit = response.data.limit);
                });
        },
        fetchOrders() {
            this.$http
                .post(
                    "/user/fetch/binary/" + this.$route.params.type + "/orders"
                )
                .then((response) => {
                    this.orders = response.data.orders;
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
        this.fetchOrders();
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
