<template>
    <div class="row match-height" style="min-height: 40vh">
        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
            <ul class="nav nav-tabs border" role="tablist" :key="api">
                <li v-if="api == 1" class="nav-item w-50">
                    <a
                        class="nav-link w-100"
                        @click.prevent="setActive('trading')"
                        :class="{ active: isActive('trading') }"
                        aria-controls="trading"
                        href="#trading"
                    >
                        Trading
                    </a>
                </li>
                <li class="nav-item" :class="api ? 'w-50' : 'w-100'">
                    <a
                        class="nav-link w-100"
                        @click.prevent="setActive('funding')"
                        :class="{ active: isActive('funding') }"
                        aria-controls="funding"
                        href="#funding"
                    >
                        Funding
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div
                    class="tan-pane fade"
                    style="max-height: 73vh; overflow-y: auto"
                    id="trading"
                    aria-labelledby="trading-tab"
                    role="tabpanel"
                    :class="isActive('trading') ? 'active show' : 'hidden'"
                >
                    <template v-if="wallets.trading != null">
                        <div
                            v-for="(wallet, index) in wallets.trading"
                            :key="index"
                            class="col-xs-6"
                        >
                            <router-link
                                :to="
                                    '../../../wallets/' +
                                    wallet.type +
                                    '/' +
                                    wallet.symbol +
                                    '/' +
                                    wallet.address
                                "
                            >
                                <div
                                    :key="wallet.address"
                                    class="d-flex justify-content-between align-items-center shadow-sm p-1 rounded mb-1"
                                    :class="
                                        checkPath(
                                            wallet.type +
                                                '/' +
                                                wallet.symbol +
                                                '/' +
                                                wallet.address
                                        )
                                            ? 'bg-wal-active'
                                            : 'bg-wal'
                                    "
                                >
                                    <div class="col">
                                        <v-lazy-image
                                            class="avatar-content"
                                            :width="40"
                                            :src="
                                                wallet.symbol
                                                    ? '/assets/images/cryptoCurrency/' +
                                                      wallet.symbol.toLowerCase() +
                                                      '.png'
                                                    : '/market/notification.png'
                                            "
                                        ></v-lazy-image>
                                    </div>
                                    <div class="col">
                                        <span
                                            :class="
                                                checkPath(
                                                    wallet.type +
                                                        '/' +
                                                        wallet.symbol +
                                                        '/' +
                                                        wallet.address
                                                )
                                                    ? 'fs-5 fw-bold text-light'
                                                    : 'fs-6 text-dark'
                                            "
                                            >{{ wallet.symbol }}</span
                                        >
                                    </div>
                                    <div class="col">
                                        <span
                                            :class="
                                                checkPath(
                                                    wallet.type +
                                                        '/' +
                                                        wallet.symbol +
                                                        '/' +
                                                        wallet.address
                                                )
                                                    ? 'fs-5 fw-bold text-light'
                                                    : 'fs-6 text-dark'
                                            "
                                            >{{
                                                wallet.balance | toMoney(4)
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </template>
                    <div class="col-xs-6">
                        <div
                            class="card align-items-center justify-content-center"
                            style="min-width: 214px; margin-bottom: 15px"
                        >
                            <i
                                class="bi bi-plus-square-dotted display-4 mt-2"
                            ></i>
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#newWallet"
                                class="btn btn-success btn-sm my-1 stretched-link"
                                @click="selectType('trading')"
                            >
                                Create Wallet
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    style="max-height: 73vh; overflow-y: auto"
                    id="funding"
                    aria-labelledby="funding-tab"
                    role="tabpanel"
                    :class="isActive('funding') ? 'active show' : 'hidden'"
                >
                    <template v-if="wallets.funding != null">
                        <div
                            v-for="(wallet, index) in wallets.funding"
                            :key="index"
                            class="col-xs-6"
                        >
                            <router-link
                                :to="
                                    '../../../wallets/' +
                                    wallet.type +
                                    '/' +
                                    wallet.symbol +
                                    '/' +
                                    wallet.address
                                "
                            >
                                <div
                                    class="d-flex justify-content-between align-items-center shadow-sm p-1 rounded mb-1"
                                    :class="
                                        checkPath('funding/' + wallet.symbol)
                                            ? 'bg-wal-active'
                                            : 'bg-wal'
                                    "
                                >
                                    <div class="col">
                                        <v-lazy-image
                                            class="avatar-content"
                                            :width="40"
                                            :src="
                                                wallet.symbol
                                                    ? '/assets/images/cryptoCurrency/' +
                                                      wallet.symbol.toLowerCase() +
                                                      '.png'
                                                    : '/market/notification.png'
                                            "
                                        ></v-lazy-image>
                                    </div>
                                    <div class="col">
                                        <span
                                            :class="
                                                checkPath(
                                                    wallet.type +
                                                        '/' +
                                                        wallet.symbol +
                                                        '/' +
                                                        wallet.address
                                                )
                                                    ? 'fs-5 fw-bold text-light'
                                                    : 'fs-6 text-dark'
                                            "
                                            >{{ wallet.symbol }}</span
                                        >
                                    </div>
                                    <div class="col">
                                        <span
                                            :class="
                                                checkPath(
                                                    wallet.type +
                                                        '/' +
                                                        wallet.symbol +
                                                        '/' +
                                                        wallet.address
                                                )
                                                    ? 'fs-5 fw-bold text-light'
                                                    : 'fs-6 text-dark'
                                            "
                                            >{{ wallet.balance }}</span
                                        >
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </template>
                    <div class="col-xs-6">
                        <div
                            class="card align-items-center justify-content-center"
                            style="min-width: 214px; margin-bottom: 15px"
                        >
                            <i
                                class="bi bi-plus-square-dotted display-4 mt-2"
                            ></i>
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#newWallet"
                                class="btn btn-success btn-sm my-1 stretched-link"
                                @click="selectType('funding')"
                            >
                                Create Wallet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <Transition
                type="animation"
                name="zoom-fade"
                mode="out-in"
                :duration="300"
            >
                <router-view
                    :key="
                        this.$route.params.symbol +
                        '/' +
                        this.$route.params.address
                    "
                    @RefreshWallet="fetchData()"
                >
                </router-view>
            </Transition>
        </div>
        <div
            class="modal fade"
            id="newWallet"
            tabindex="-1"
            aria-labelledby="newWallet"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5 class="modal-title">Create New Wallet</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="">
                        <div class="input-group w-100 p-1">
                            <span class="input-group-text" id="symbol-search"
                                >Symbol</span
                            >
                            <input
                                class="form-control"
                                v-model="filters.symbol.value"
                            />
                        </div>
                        <div
                            class="table-responsive"
                            style="height: 500px; overflow-y: auto"
                        >
                            <v-table
                                v-if="currencies != null"
                                :data="currencies"
                                :filters="filters"
                                class="table table-hover tableFixHead"
                            >
                                <thead slot="head">
                                    <tr>
                                        <v-th
                                            sortKey="symbol"
                                            defaultSort="asc"
                                            scope="col"
                                            >Symbol</v-th
                                        >
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody slot="body" slot-scope="{ displayData }">
                                    <tr
                                        v-for="row in displayData"
                                        :key="row.id"
                                    >
                                        <td data-label="symbol">
                                            <v-lazy-image
                                                class="avatar-content me-1"
                                                :width="40"
                                                :src="
                                                    row.symbol
                                                        ? '/assets/images/cryptoCurrency/' +
                                                          row.symbol.toLowerCase() +
                                                          '.png'
                                                        : '/market/notification.png'
                                                "
                                                loading="lazy"
                                            ></v-lazy-image>
                                            {{ row.symbol }}
                                        </td>
                                        <td data-label="action">
                                            <button
                                                class="btn btn-sm btn-success"
                                                :disabled="loading"
                                                @click="
                                                    CreateWallet(row.symbol)
                                                "
                                            >
                                                Create Wallet
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import WalletDetail from "../components/wallets/WalletDetail.vue";

export default {
    props: ["user"],
    // component list
    components: {
        WalletDetail,
    },

    // component data
    data() {
        return {
            isFunding: false,
            activeItem:
                this.$route.params.type != null
                    ? this.$route.params.type == "trading"
                        ? "trading"
                        : "funding"
                    : "trading",
            filters: {
                symbol: { value: "", keys: ["symbol"] },
            },
            wallets: [],
            api: 1,
            currencies: [],
            address: this.$route.params.addres,
            SelectedWallet: {},
            type: {},
            loading: false,
        };
    },

    watch: {
        $route(to, from) {
            this.type = this.$route.params.type;
            this.symbol = this.$route.params.symbol;
            this.address = this.$route.params.address;
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
        checkPath(path) {
            if (window.location.href.indexOf(path) > -1) {
                return true;
            }
        },
        fetchData() {
            this.$http.post("/user/fetch/wallets").then((response) => {
                (this.wallets = response.data.wallets),
                    (this.api = response.data.api),
                    (this.currencies = response.data.currencies);
                if (this.api == 0) {
                    this.activeItem = "funding";
                }
            });
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        CreateWallet(symbol) {
            (this.loading = true),
                this.$http
                    .post("/user/wallet/j/create", {
                        type: this.type,
                        symbol: symbol,
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
                        $("#newWallet").modal("hide");
                    });
        },
        selectType(type) {
            this.type = type;
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
