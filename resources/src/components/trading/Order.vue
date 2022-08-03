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
                    Market
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link"
                    @click.prevent="setActive('pills-limit')"
                    :class="{ active: isActive('pills-limit') }"
                    href="#pills-limit"
                >
                    Limit
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link"
                    @click.prevent="setActive('pills-wallets')"
                    :class="{ active: isActive('pills-wallets') }"
                    href="#pills-wallets"
                >
                    Wallets
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
                <div class="row pb-1 px-1">
                    <div class="col-6">
                        <form class="text-center" @submit.prevent="marketBuy()">
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Amount</span>
                                <span>
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('market', 0.25)"
                                        >25%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('market', 0.5)"
                                        >50%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('market', 0.75)"
                                        >75%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('market', 1)"
                                        >100%</a
                                    >
                                </span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 MarketBuy"
                                    :min="
                                        limit.min_amount ? limit.min_amount : 0
                                    "
                                    :max="limit.max_amount"
                                    step="0.00000001"
                                    required=""
                                    v-model="amountMarketBuy"
                                    @keyup="getPriceBuy('market')"
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ symbol }}</span
                                >
                                <span
                                    class="input-group-text text-dark border-0 ms-1"
                                >
                                    <a
                                        @click="
                                            amountMarketBuy++;
                                            getPriceBuy('market');
                                        "
                                        ><i class="bi bi-caret-up-fill"></i
                                    ></a>
                                    <a
                                        @click="
                                            amountMarketBuy--;
                                            getPriceBuy('market');
                                        "
                                        ><i class="bi bi-caret-down-fill"></i
                                    ></a>
                                </span>
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Total</span>
                                <span
                                    >Processing Fee:
                                    <span class="text-warning"
                                        >{{ fee }}%</span
                                    ></span
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    disabled
                                    aria-label="Amount (to the nearest dollar)"
                                    v-model="totalbuymarket"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div class="d-grid mt-1" :key="bid">
                                <button
                                    class="btn btn-success btn-sm marketType fs-5"
                                    id="marketOrderBtnBuy"
                                    type="submit"
                                    disabled
                                    v-if="bid == null"
                                >
                                    Loading Orderbook...
                                </button>
                                <button
                                    class="btn btn-success btn-sm marketType fs-5"
                                    id="marketOrderBtnBuy"
                                    type="submit"
                                    :disabled="loading"
                                    v-else
                                >
                                    Buy
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6">
                        <form
                            class="text-center"
                            @submit.prevent="marketSell()"
                        >
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Amount</span>
                                <span>
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('market', 0.25)"
                                        >25%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('market', 0.5)"
                                        >50%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('market', 0.75)"
                                        >75%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('market', 1)"
                                        >100%</a
                                    >
                                </span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 MarketSell"
                                    :min="
                                        limit.min_amount ? limit.min_amount : 0
                                    "
                                    :max="limit.max_amount"
                                    step="0.00000001"
                                    required=""
                                    v-model="amountMarketSell"
                                    @keyup="getPriceSell('market')"
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ symbol }}</span
                                >
                                <span
                                    class="input-group-text text-dark border-0 ms-1"
                                >
                                    <a
                                        @click="
                                            amountMarketSell++;
                                            getPriceSell('market');
                                        "
                                        ><i class="bi bi-caret-up-fill"></i
                                    ></a>
                                    <a
                                        @click="
                                            amountMarketSell--;
                                            getPriceSell('market');
                                        "
                                        ><i class="bi bi-caret-down-fill"></i
                                    ></a>
                                </span>
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Total</span>
                                <span
                                    >Processing Fee:
                                    <span class="text-warning"
                                        >{{ fee }}%</span
                                    ></span
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    disabled
                                    aria-label="Amount (to the nearest dollar)"
                                    v-model="totalsellmarket"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div class="d-grid mt-1" :key="bid">
                                <button
                                    class="btn btn-danger btn-sm marketType fs-5"
                                    id="marketOrderBtnSell"
                                    type="submit"
                                    disabled
                                    v-if="bid == null"
                                >
                                    Loading Orderbook...
                                </button>
                                <button
                                    class="btn btn-danger btn-sm marketType fs-5"
                                    id="marketOrderBtnSell"
                                    type="submit"
                                    :disabled="loading"
                                    v-else
                                >
                                    Sell
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div
                class="tab-pane fade"
                :class="{ 'active show': isActive('pills-limit') }"
                id="pills-limit"
                role="tabpanel"
                aria-labelledby="pills-limit-tab"
            >
                <div class="row pb-1 px-1">
                    <div class="col-6">
                        <form class="text-center" @submit.prevent="limitBuy()">
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Price</span>
                                <a class="text-warning" @click="getBestAsk()"
                                    >Best Ask</a
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 priceNowAsk"
                                    min="0"
                                    step="0.00000001"
                                    required=""
                                    id="price"
                                    v-model="priceBuy"
                                    placeholder="Price"
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Amount</span>
                                <span>
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('limit', 0.25)"
                                        >25%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('limit', 0.5)"
                                        >50%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('limit', 0.75)"
                                        >75%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercBuy('limit', 1)"
                                        >100%</a
                                    >
                                </span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 LimitBuy"
                                    :min="
                                        limit.min_amount ? limit.min_amount : 0
                                    "
                                    :max="limit.max_amount"
                                    step="0.00000001"
                                    required=""
                                    v-model="amountLimitBuy"
                                    aria-label="Amount (to the nearest dollar)"
                                    @keyup="getPriceBuy('limit')"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ symbol }}</span
                                >
                                <span
                                    class="input-group-text text-dark border-0 ms-1"
                                >
                                    <a
                                        @click="
                                            amountLimitBuy++;
                                            getPriceBuy('limit');
                                        "
                                        ><i class="bi bi-caret-up-fill"></i
                                    ></a>
                                    <a
                                        @click="
                                            amountLimitBuy--;
                                            getPriceBuy('limit');
                                        "
                                        ><i class="bi bi-caret-down-fill"></i
                                    ></a>
                                </span>
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Total</span>
                                <span
                                    >Processing Fee:
                                    <span class="text-warning"
                                        >{{ fee }}%</span
                                    ></span
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    aria-label="Amount (to the nearest dollar)"
                                    v-model="totalbuylimit"
                                    disabled
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div class="d-grid mt-1" :key="bid">
                                <button
                                    class="btn btn-success btn-sm limitType fs-5"
                                    id="limitOrderBtnBuy"
                                    type="submit"
                                    disabled
                                    v-if="bid == null"
                                >
                                    Loading Orderbook...
                                </button>
                                <button
                                    class="btn btn-success btn-sm limitType fs-5"
                                    id="limitOrderBtnBuy"
                                    type="submit"
                                    :disabled="loading"
                                    v-else
                                >
                                    Buy
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6">
                        <form class="text-center" @submit.prevent="limitSell()">
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Price</span>
                                <a class="text-warning" @click="getBestBid()"
                                    >Best Bid</a
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 priceNowAsk"
                                    min="0"
                                    step="0.00000001"
                                    required=""
                                    id="price"
                                    v-model="priceSell"
                                    placeholder="Price"
                                    aria-label="Amount (to the nearest dollar)"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Amount</span>
                                <span>
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('limit', 0.25)"
                                        >25%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('limit', 0.5)"
                                        >50%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('limit', 0.75)"
                                        >75%</a
                                    >
                                    <a
                                        class="text-dark"
                                        @click="getPercSell('limit', 1)"
                                        >100%</a
                                    >
                                </span>
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0 LimitSell"
                                    :min="
                                        limit.min_amount ? limit.min_amount : 0
                                    "
                                    :max="limit.max_amount"
                                    step="0.00000001"
                                    required=""
                                    v-model="amountLimitSell"
                                    aria-label="Amount (to the nearest dollar)"
                                    @keyup="getPriceSell('limit')"
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ symbol }}</span
                                >
                                <span
                                    class="input-group-text text-dark border-0 ms-1"
                                >
                                    <a
                                        @click="
                                            amountLimitSell++;
                                            getPriceSell('limit');
                                        "
                                        ><i class="bi bi-caret-up-fill"></i
                                    ></a>
                                    <a
                                        @click="
                                            amountLimitSell--;
                                            getPriceSell('limit');
                                        "
                                        ><i class="bi bi-caret-down-fill"></i
                                    ></a>
                                </span>
                            </div>
                            <label
                                for="basic-url"
                                class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                            >
                                <span>Total</span>
                                <span
                                    >Processing Fee:
                                    <span class="text-warning"
                                        >{{ fee }}%</span
                                    ></span
                                >
                            </label>
                            <div class="input-group input-group-sm mb-1">
                                <input
                                    type="number"
                                    class="form-control text-dark border-0"
                                    aria-label="Amount (to the nearest dollar)"
                                    v-model="totalselllimit"
                                    disabled
                                />
                                <span
                                    class="input-group-text text-dark border-0"
                                    >{{ currency }}</span
                                >
                            </div>
                            <div class="d-grid mt-1" :key="bid">
                                <button
                                    class="btn btn-danger btn-sm limitType fs-5"
                                    id="limitOrderBtnSell"
                                    type="submit"
                                    disabled
                                    v-if="bid == null"
                                >
                                    Loading Orderbook...
                                </button>
                                <button
                                    class="btn btn-danger btn-sm limitType fs-5"
                                    id="limitOrderBtnSell"
                                    type="submit"
                                    :disabled="loading"
                                    v-else
                                >
                                    Sell
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div
                class="tab-pane fade"
                :class="{ 'active show': isActive('pills-wallets') }"
                id="pills-wallets"
            >
                <div class="row pb-1 px-1">
                    <div class="col-md-6 col-sm-12" :key="walSym">
                        <label
                            for="basic-url"
                            class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                        >
                            <a class="text-dark">{{ symbol }} Wallet</a>
                        </label>
                        <form
                            v-if="walSym == null"
                            @submit.prevent="createWallet(symbol)"
                        >
                            <button
                                type="submit"
                                class="btn btn-success btn-sm"
                                :disabled="loading"
                            >
                                Create Wallet
                            </button>
                        </form>
                        <div v-else class="input-group input-group-sm mb-1">
                            <input
                                type="number"
                                class="form-control text-dark border-0"
                                :value="walSym"
                                :key="walSym"
                                readonly
                                aria-label="Amount (to the nearest dollar)"
                            />
                            <span class="input-group-text text-dark border-0">{{
                                symbol
                            }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12" :key="walCur">
                        <label
                            for="basic-url"
                            class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
                        >
                            <a class="text-dark">{{ currency }} Wallet</a>
                        </label>
                        <form
                            v-if="walCur == null"
                            @submit.prevent="createWallet(currency)"
                        >
                            <button
                                type="submit"
                                class="btn btn-success btn-sm"
                                :disabled="loading"
                            >
                                Create Wallet
                            </button>
                        </form>
                        <div v-else class="input-group input-group-sm mb-1">
                            <input
                                type="number"
                                class="form-control text-dark border-0"
                                :value="walCur"
                                :key="walCur"
                                readonly
                                aria-label="Amount (to the nearest dollar)"
                            />
                            <span class="input-group-text text-dark border-0">{{
                                currency
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// component
export default {
    props: [
        "provider",
        "symbol",
        "currency",
        "limit",
        "limits",
        "fee",
        "pfee",
        "api",
        "bid",
        "ask",
    ],

    // component list
    components: {},
    // component data
    data() {
        return {
            activeItem: "pills-market",
            amountMarketBuy: {},
            amountMarketSell: {},
            amountLimitBuy: {},
            amountLimitSell: {},
            priceBuy: 0,
            priceSell: 0,
            loading: false,
            walSym: null,
            walCur: null,
            wallet_type: null,
            totalbuymarket: 0,
            totalsellmarket: 0,
            totalbuylimit: 0,
            totalselllimit: 0,
        };
    },

    // custom methods
    methods: {
        fetchWallet(coin) {
            this.$http
                .post("/user/fetch/wallet", {
                    type: this.wallet_type,
                    symbol: coin,
                })
                .then((response) => {
                    if (coin == this.symbol) {
                        this.walSym = response.data.balance;
                    } else if (coin == this.currency) {
                        this.walCur = response.data.balance;
                    }
                });
        },
        createWallet(coin) {
            this.loading = true;
            this.$http
                .post("/user/wallet/j/create", {
                    type: this.wallet_type,
                    symbol: coin,
                })
                .then((response) => {
                    this.fetchWallet(coin);
                    this.$toast[response.data.type](response.data.message);
                })
                .catch((error) => {
                    this.$toast.error(error.response.data);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        marketBuy() {
            this.loading = true;
            if (this.ask > 0) {
                if (this.pfee > 0) {
                    this.$http
                        .post("/user/trade/store", {
                            amount: this.amountMarketBuy,
                            symbol: this.symbol,
                            currency: this.currency,
                            tradeType: "market",
                            type: 1,
                            wallettype: this.wallet_type,
                            price: this.ask * this.pfee,
                        })
                        .then((response) => {
                            this.$toast[response.data.type](
                                response.data.message
                            );
                            this.$emit("OrderPlaced");
                            this.fetchWallet(this.symbol);
                            this.fetchWallet(this.currency);
                        })
                        .catch((error) => {
                            this.$toast.error(error.response.data);
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                } else {
                    this.$toast.error(
                        "Error fees not set, Please report to support"
                    );
                    this.loading = false;
                }
            } else {
                this.$toast.error("Please wait for orderbook to load");
                this.loading = false;
            }
        },
        marketSell() {
            this.loading = true;
            if (this.bid > 0) {
                this.$http
                    .post("/user/trade/store", {
                        amount: this.amountMarketSell,
                        symbol: this.symbol,
                        currency: this.currency,
                        tradeType: "market",
                        type: 2,
                        wallettype: this.wallet_type,
                        price: this.bid,
                    })
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message);
                        this.$emit("OrderPlaced");
                        this.fetchWallet(this.symbol);
                        this.fetchWallet(this.currency);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                this.$toast.error("Please wait for orderbook to load");
                this.loading = false;
            }
        },
        limitBuy() {
            this.loading = true;
            if (this.priceBuy > 0) {
                this.$http
                    .post("/user/trade/store", {
                        amount: this.amountLimitBuy,
                        price: this.priceBuy,
                        symbol: this.symbol,
                        currency: this.currency,
                        tradeType: "limit",
                        type: 1,
                        wallettype: this.wallet_type,
                    })
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message);
                        this.$emit("OrderPlaced");
                        this.fetchWallet(this.symbol);
                        this.fetchWallet(this.currency);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                this.$toast.error("Please set a valid price");
                this.loading = false;
            }
        },
        limitSell() {
            this.loading = true;
            if (this.priceSell > 0) {
                this.$http
                    .post("/user/trade/store", {
                        amount: this.amountLimitSell,
                        price: this.priceSell,
                        symbol: this.symbol,
                        currency: this.currency,
                        tradeType: "limit",
                        type: 2,
                        wallettype: this.wallet_type,
                    })
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message);
                        this.$emit("OrderPlaced");
                        this.fetchWallet(this.symbol);
                        this.fetchWallet(this.currency);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                this.$toast.error("Please set a valid price");
                this.loading = false;
            }
        },
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
        getPercBuy(type, perc) {
            if (type == "market") {
                if (this.ask != null) {
                    var val = (this.walCur * perc) / this.pfee;
                    this.amountMarketBuy = val / this.ask;
                    this.totalbuymarket = this.walCur * perc;
                } else {
                    this.$toast.error(
                        "Create " + this.currency + " Wallet First"
                    );
                }
            } else {
                if (this.ask != null) {
                    var val = (this.walCur * perc) / this.pfee;
                    this.amountLimitBuy = val / this.ask;
                    this.totalbuylimit = this.walCur * perc;
                } else {
                    this.$toast.error(
                        "Create " + this.currency + " Wallet First"
                    );
                }
            }
        },
        getPercSell(type, perc) {
            if (type == "market") {
                if (this.bid != null) {
                    this.amountMarketSell = this.walSym * perc;
                    this.totalsellmarket = this.walSym * perc * this.bid;
                } else {
                    this.$toast.error(
                        "Create " + this.symbol + " Wallet First"
                    );
                }
            } else {
                if (this.bid != null) {
                    this.amountLimitSell = this.walSym * perc;
                    this.totalselllimit = this.walSym * perc * this.bid;
                } else {
                    this.$toast.error(
                        "Create " + this.symbol + " Wallet First"
                    );
                }
            }
        },
        getPriceBuy(type) {
            if (type == "market") {
                if (this.ask != null) {
                    var val = this.amountMarketBuy * this.ask * this.pfee;
                    if (this.walCur > val) {
                        this.totalbuymarket = (
                            this.amountMarketBuy *
                            this.ask *
                            this.pfee
                        ).toFixed(6);
                    } else {
                        this.$toast.error(
                            "Order price higher than your " +
                                this.currency +
                                " wallet balance"
                        );
                    }
                } else {
                    this.$toast.error("Try Again");
                }
            } else {
                if (this.ask != null) {
                    var val = this.amountLimitBuy * this.ask * this.pfee;
                    if (this.walCur > val) {
                        this.totalbuylimit = (
                            this.amountLimitBuy *
                            this.ask *
                            this.pfee
                        ).toFixed(6);
                    } else {
                        this.$toast.error(
                            "Order price higher than your " +
                                this.currency +
                                " wallet balance"
                        );
                    }
                } else {
                    this.$toast.error("Try Again");
                }
            }
        },
        getPriceSell(type) {
            if (type == "market") {
                if (this.bid != null) {
                    if (this.walSym > this.amountMarketSell) {
                        this.totalsellmarket = (
                            this.amountMarketSell * this.bid
                        ).toFixed(6);
                    } else {
                        this.$toast.error(
                            "Order amount higher than your " +
                                this.symbol +
                                " wallet balance"
                        );
                    }
                } else {
                    this.$toast.error("Try Again");
                }
            } else {
                if (this.bid != null) {
                    if (this.walSym > this.amountLimitSell) {
                        this.totalselllimit = (
                            this.amountLimitSell * this.bid
                        ).toFixed(6);
                    } else {
                        this.$toast.error(
                            "Order amount higher than your " +
                                this.symbol +
                                " wallet balance"
                        );
                    }
                } else {
                    this.$toast.error("Try Again");
                }
            }
        },
        getBestAsk() {
            this.priceBuy = this.ask;
        },
        getBestBid() {
            this.priceSell = this.bid;
        },
    },

    // on component created
    created() {
        if (this.api == 1) {
            this.wallet_type = "trading";
        } else {
            this.wallet_type = "funding";
        }
        this.fetchWallet(this.symbol);
        this.fetchWallet(this.currency);
    },

    // on component mounted
    mounted() {
        this.amountMarketBuy = this.limit.min_amount;
        this.amountMarketSell = this.limit.min_amount;
        this.amountLimitBuy = this.limit.min_amount;
        this.amountLimitSell = this.limit.min_amount;
    },

    // on component destroyed
    destroyed() {},
};
</script>
