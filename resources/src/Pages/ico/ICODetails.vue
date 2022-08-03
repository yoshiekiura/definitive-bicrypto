<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div
                                class="d-flex justify-content-between align-items-center"
                            >
                                <div
                                    class="d-flex justify-content-start align-items-center"
                                >
                                    <img
                                        v-if="ico.icon != null"
                                        class="avatar"
                                        height="48px"
                                        width="48px"
                                        :src="
                                            ico.icon
                                                ? '/assets/images/ico/' +
                                                  ico.icon
                                                : '/market/notification.png'
                                        "
                                        alt=""
                                        style="filter: grayscale(0)"
                                    />
                                    <vue-skeleton-loader
                                        v-else
                                        type="circle"
                                        :width="48"
                                        :height="48"
                                        animation="fade"
                                    />
                                    <span class="ms-1">
                                        <h1 v-if="ico.name != null">
                                            {{ ico.name }}
                                        </h1>
                                        <vue-skeleton-loader
                                            v-else
                                            type="rect"
                                            :width="300"
                                            :height="10"
                                            animation="fade"
                                        />
                                    </span>
                                </div>
                                <div :key="ico.status">
                                    <span
                                        v-if="ico.status == 0"
                                        class="badge bg-warning"
                                        >Upcoming</span
                                    >
                                    <span
                                        v-else-if="ico.status == 1"
                                        class="badge bg-success"
                                        >Sale Live</span
                                    >
                                    <span
                                        v-else-if="ico.status == 2"
                                        class="badge bg-danger"
                                        >Sale Ended</span
                                    >
                                    <span
                                        v-else-if="ico.status == 3"
                                        class="badge bg-secondary"
                                        >Canceled</span
                                    >
                                    <span v-else class="badge bg-secondary">
                                        <vue-skeleton-loader
                                            type="rect"
                                            :width="60"
                                            :height="10"
                                            animation="fade"
                                        />
                                    </span>
                                </div>
                            </div>
                            <div v-if="ico.desc != null" class="my-1">
                                {{ ico.desc }}
                            </div>
                            <div v-else class="my-1">
                                <vue-skeleton-loader
                                    class="mb-1"
                                    type="rect"
                                    :width="500"
                                    :height="10"
                                    animation="fade"
                                />
                                <vue-skeleton-loader
                                    class="mb-1"
                                    type="rect"
                                    :width="500"
                                    :height="10"
                                    animation="fade"
                                />
                                <vue-skeleton-loader
                                    class="mb-1"
                                    type="rect"
                                    :width="500"
                                    :height="10"
                                    animation="fade"
                                />
                                <vue-skeleton-loader
                                    class="mb-1"
                                    type="rect"
                                    :width="400"
                                    :height="10"
                                    animation="fade"
                                />
                            </div>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Presale Address</td>
                                    <td>
                                        <a
                                            :href="ico.presale_address"
                                            target="_blank"
                                            rel="noreferrer nofollow"
                                            >{{ ico.address }}</a
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Token Name</td>
                                    <td>{{ ico.name }}</td>
                                </tr>
                                <tr>
                                    <td>Token Symbol</td>
                                    <td>{{ ico.symbol }}</td>
                                </tr>
                                <tr>
                                    <td>Token Decimals</td>
                                    <td>{{ ico.decimals }}</td>
                                </tr>
                                <tr>
                                    <td>Token Address</td>
                                    <td>
                                        <a
                                            class="mr-1"
                                            :href="ico.address"
                                            target="_blank"
                                            rel="noreferrer nofollow"
                                            >{{ ico.address }}</a
                                        ><br />
                                        <p class="help is-info">
                                            (Do not send
                                            {{ ico.network_symbol }} to the
                                            token address!)
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Supply</td>
                                    <td>
                                        {{ ico.total_supply | toMoney(2) }}
                                        {{ ico.symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tokens For Presale</td>
                                    <td>
                                        {{ ico.presale_supply | toMoney(2) }}
                                        {{ ico.symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tokens For Liquidity</td>
                                    <td>
                                        {{ ico.liquidity_supply | toMoney(2) }}
                                        {{ ico.symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Initial Market Cap (estimate)</td>
                                    <td>${{ ico.initial_cap | toMoney(2) }}</td>
                                </tr>
                                <tr>
                                    <td>Soft Cap</td>
                                    <td>
                                        {{ ico.soft_cap | toMoney(2) }}
                                        {{ ico.network_symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Max Owner Receive</td>
                                    <td>
                                        {{ ico.owner_max | toMoney(2) }}
                                        {{ ico.network_symbol }}<br />
                                        <div
                                            class="has-text-info is-size-7"
                                            :key="ico.owner_recieved"
                                        >
                                            (Current:
                                            {{
                                                ico.owner_recieved | toMoney(4)
                                            }}
                                            {{ ico.network_symbol }})
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>
                            <td>Amount Till Rebalance</td>
                            <td>{{ ico }} {{ ico.network_symbol }}</td>
                        </tr> -->
                                <tr>
                                    <td>Presale Start Time</td>
                                    <td>
                                        {{
                                            ico.soft_start
                                                | moment("dddd, MMMM Do YYYY")
                                        }}
                                        (UTC)
                                    </td>
                                </tr>
                                <tr>
                                    <td>Presale End Time</td>
                                    <td>
                                        {{
                                            ico.soft_end
                                                | moment("dddd, MMMM Do YYYY")
                                        }}
                                        (UTC)
                                    </td>
                                </tr>
                                <!-- <tr>
                            <td>Listing On</td>
                            <td><a class="mr-1"
                                    href="https://pancakeswap.finance/swap?outputCurrency=0x868149c7EaCD7EB0aB71A43f7b9Ff25eC1DC8023"
                                    target="_blank" rel="noreferrer nofollow">Pancakeswap</a></td>
                        </tr> -->
                                <tr>
                                    <td>Liquidity Percent</td>
                                    <td>{{ ico.liquidity_percent }}%</td>
                                </tr>
                                <tr>
                                    <td>Liquidity Lockup Time</td>
                                    <td>
                                        {{ ico.lockup }} days after pool ends
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="ico.stage != null" class="text-center mt-1">
                            <Countdown
                                v-if="ico.stage == 0"
                                :deadline="ico.soft_start"
                            ></Countdown>
                            <Countdown
                                v-else-if="ico.stage == 1"
                                :deadline="ico.soft_end"
                            ></Countdown>
                            <Countdown
                                v-else-if="ico.stage == 2"
                                :deadline="ico.hard_end"
                            ></Countdown>
                        </div>
                        <vue-skeleton-loader
                            v-else
                            class="text-center mt-1"
                            type="rect"
                            :width="240"
                            :height="55"
                            animation="fade"
                        />
                        <div class="mb-1" :key="ico.soft_raised">
                            <p class="title">
                                Progress (<span class="text-success"
                                    >{{
                                        ((ico.soft_raised / ico.soft_cap) * 100)
                                            | toMoney(2)
                                    }}%</span
                                >)
                            </p>
                            <span class="mb-1">
                                <div id="myRangeColor" class="progress">
                                    <div
                                        id="myRange"
                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar"
                                        aria-valuenow="50"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                        :style="
                                            'width:' +
                                            (ico.soft_raised / ico.soft_cap) *
                                                100 +
                                            '%'
                                        "
                                    ></div>
                                </div>
                            </span>
                            <small class="d-flex justify-content-between">
                                <span :key="ico.soft_raised"
                                    >{{ ico.soft_raised | toMoney(2) }}
                                    {{ ico.symbol }}</span
                                >
                                <span
                                    >{{ ico.soft_cap | toMoney(2) }}
                                    {{ ico.symbol }}</span
                                >
                            </small>
                        </div>
                        <label class="text-start" for="amount"
                            >Recieving Wallet</label
                        >
                        <div class="input-group mb-1 w-auto">
                            <input
                                type="text"
                                class="form-control"
                                name="rec_wallet"
                                v-model="rec_wallet"
                            />
                            <span
                                class="input-group-text text-light"
                                @click="change_rec_wallet()"
                                :disabled="loading"
                                ><i class="bi bi-arrow-repeat"></i
                            ></span>
                        </div>
                        <label class="text-start" for="amount">Amount</label>
                        <div class="input-group mb-1 w-auto">
                            <input
                                type="text"
                                class="form-control"
                                name="amount"
                                v-model="amount"
                                @keyup="costCal()"
                            />
                            <span class="input-group-text text-light">{{
                                ico.symbol
                            }}</span>
                        </div>
                        <label class="text-start" for="cost">Cost</label>
                        <div class="input-group mb-1 w-auto">
                            <input
                                type="text"
                                class="form-control"
                                v-model="cost"
                                readonly
                                disabled
                            />
                            <span class="input-group-text text-light">{{
                                ico.network_symbol
                            }}</span>
                        </div>
                        <label class="text-start" for="balance">Balance</label>
                        <div :key="balance">
                            <div
                                v-if="balance != null"
                                class="w-100 mb-1 btn btn-outline-success"
                                disabled
                            >
                                {{ balance }}
                                {{ wallet_symbol }}
                            </div>
                            <div
                                v-else
                                class="w-100 mb-1 btn btn-outline-warning"
                                @click="createWallet()"
                                :disabled="loading"
                            >
                                Create {{ ico.network_symbol }} Wallet
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-footer d-flex justify-content-between"
                        v-if="ico.status == 1"
                    >
                        <button
                            class="btn btn-success"
                            @click="purchase()"
                            :disabled="loading"
                        >
                            Buy
                        </button>
                        <!-- <button class="btn btn-warning">Metamask</button> -->
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Status</td>
                                    <td :key="ico.status">
                                        <span
                                            v-if="ico.status == 0"
                                            class="text-warning"
                                            >Upcoming</span
                                        >
                                        <span
                                            v-else-if="ico.status == 1"
                                            class="text-success"
                                            >In Progress</span
                                        >
                                        <span
                                            v-else-if="ico.status == 2"
                                            class="text-danger"
                                            >Sale Ended</span
                                        >
                                        <span
                                            v-else-if="ico.status == 3"
                                            class="text-secondary"
                                            >Canceled</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Current Rate</td>
                                    <td>
                                        1 {{ ico.network_symbol }} =
                                        {{ ico.rate | toMoney(2) }}
                                        {{ ico.symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Contributors</td>
                                    <td :key="ico.contributors">
                                        {{ ico.contributors }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Countdown from "vuejs-countdown";

export default {
    props: ["user"],
    // component list
    components: {
        Countdown,
    },

    // component data
    data() {
        return {
            ico: [],
            amount: 0,
            rec_wallet: "",
            wallet_symbol: null,
            balance: null,
            cost: 0,
            loading: false,
        };
    },

    // custom methods
    methods: {
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchData() {
            this.$http
                .post(
                    "/user/fetch/ico/" +
                        window.location.href.substring(
                            window.location.href.lastIndexOf("/") + 1
                        )
                )
                .then((response) => {
                    (this.ico = response.data.ico),
                        (this.rec_wallet = response.data.rec_wallet),
                        (this.wallet_symbol = response.data.ico.network_symbol),
                        (this.balance = response.data.balance);
                });
        },
        purchase() {
            (this.loading = true),
                this.$http
                    .post("/user/store/ico", {
                        amount: this.amount,
                        cost: this.amount / this.ico.rate,
                        ico_symbol: this.ico.symbol,
                        ico_id: this.ico.id,
                        symbol: this.ico.network_symbol,
                        rec_wallet: this.rec_wallet,
                    })
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message);
                        this.fetchData();
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        },
        fetchWallet() {
            this.$http
                .post("/user/fetch/wallet", {
                    symbol: this.wallet_symbol,
                    type: "funding",
                })
                .then((response) => {
                    this.balance = response.data.balance;
                });
        },
        createWallet() {
            (this.loading = true),
                this.$http
                    .post("/user/wallet/j/create", {
                        symbol: this.wallet_symbol,
                        type: "funding",
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
        change_rec_wallet() {
            (this.loading = true),
                this.$http
                    .post("/user/store/ico/rec_wallet", {
                        rec_wallet: this.rec_wallet,
                        network_symbol: this.ico.network_symbol,
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
        costCal() {
            this.cost = this.amount / this.ico.rate;
        },
    },

    // on component created
    created() {
        this.fetchData();
    },

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
