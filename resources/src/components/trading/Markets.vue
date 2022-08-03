<template>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-icon" style="position: relative; top: -5px">
                <i
                    class="bi bi-chevron-left text-warning fs-4"
                    @click.prevent="scrollLeft()"
                ></i>
            </button>
            <ul
                class="nav nav-tabs nf"
                role="tablist"
                style="overflow-x: hidden"
            >
                <li class="nav-item">
                    <a
                        class="nav-link"
                        @click.prevent="setActive('fav')"
                        :class="{ active: isActive('fav') }"
                        href="#fav"
                        ><i class="bi bi-star"></i
                    ></a>
                </li>
                <li
                    class="nav-item"
                    v-for="(pair, index) in pairs"
                    :key="index"
                >
                    <a
                        class="nav-link"
                        @click.prevent="setActive(pair)"
                        :class="{ active: isActive(pair) }"
                        href="#profile"
                        >{{ pair }}</a
                    >
                </li>
            </ul>
            <button class="btn btn-icon" style="position: relative; top: -5px">
                <i
                    class="bi bi-chevron-right text-warning fs-4"
                    @click.prevent="scrollRight()"
                ></i>
            </button>
        </div>
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade"
                :class="{ 'active show': isActive('fav') }"
                id="fav"
            >
                <div class="row">
                    <div class="col-12 card-search custom-data-search">
                        <div class="input-group input-group-sm px-1 mb-1">
                            <span
                                class="input-group-text text-dark border-0"
                                id="basic-addon1"
                                ><i class="bi bi-search"></i
                            ></span>
                            <input
                                type="text"
                                name="search_table_fav"
                                class="form-control form-control-sm text-dark border-0"
                                placeholder="Search..."
                            />
                        </div>
                    </div>
                </div>
                <table
                    class="table text-dark table-sm table-borderless tableFixHead custom-data-table-fav"
                >
                    <thead class="text-muted">
                        <th scope="col">Pair</th>
                        <th class="d-lg-none d-xl-block" scope="col">Change</th>
                        <th scope="col">Price</th>
                    </thead>
                    <tbody>
                        <tr v-for="(fav, index) in favs" :key="index">
                            <td>
                                <div class="d-flex justify-content-start">
                                    <form
                                        @submit.prevent="
                                            removeFromWatchlist(fav.id)
                                        "
                                    >
                                        <button
                                            type="submit"
                                            class="watchlisted"
                                            style="
                                                background: transparent;
                                                border: transparent;
                                            "
                                        >
                                            <i
                                                class="me-1 text-warning bi bi-star-fill"
                                            ></i>
                                        </button>
                                    </form>
                                    <router-link
                                        :to="
                                            '../' +
                                            fav.currency +
                                            '/' +
                                            fav.pair
                                        "
                                    >
                                        <span class="text-dark fw-bold">{{
                                            fav.currency
                                        }}</span
                                        >/<span
                                            class="text-secondary fw-bold"
                                            >{{ fav.pair }}</span
                                        >
                                    </router-link>
                                </div>
                            </td>

                            <td class="d-lg-none d-xl-block">
                                <span
                                    :class="'change-' + fav.currency + fav.pair"
                                ></span>
                            </td>
                            <td>
                                <span
                                    :class="'tic-' + fav.currency + fav.pair"
                                ></span
                                ><i
                                    :class="
                                        'tic-' +
                                        fav.currency +
                                        fav.pair +
                                        '-icon bi'
                                    "
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="tab-pane fade"
                v-for="(mark, index) in markets"
                :key="index"
                :class="{ 'active show': isActive(index) }"
                :id="{ index }"
            >
                <div class="row">
                    <div class="col-12 card-search custom-data-search">
                        <div class="input-group input-group-sm px-1 mb-1">
                            <span
                                class="input-group-text text-dark border-0"
                                id="basic-addon1"
                                ><i class="bi bi-search"></i
                            ></span>
                            <input
                                type="text"
                                name="search_table"
                                class="form-control form-control-sm text-dark border-0"
                                placeholder="Search..."
                            />
                        </div>
                    </div>
                </div>
                <table
                    class="table text-dark table-sm table-borderless tableFixHead"
                    :class="'custom-data-table-' + index"
                >
                    <thead class="text-muted">
                        <th scope="col">Pair</th>
                    </thead>
                    <tbody>
                        <tr v-for="(market, index) in mark" :key="index">
                            <td>
                                <div class="d-flex justify-content-start">
                                    <form
                                        @submit.prevent="
                                            addToWatchlist(
                                                market.currency,
                                                market.pair
                                            )
                                        "
                                    >
                                        <button
                                            type="submit"
                                            class="not-watchlisted"
                                            style="
                                                background: transparent;
                                                border: transparent;
                                            "
                                        >
                                            <i
                                                class="me-1 text-secondary bi bi-star"
                                            ></i>
                                        </button>
                                    </form>
                                    <router-link
                                        :to="
                                            '../' +
                                            market.currency +
                                            '/' +
                                            market.pair
                                        "
                                    >
                                        <span class="text-dark fw-bold">{{
                                            market.currency
                                        }}</span
                                        >/<span
                                            class="text-secondary fw-bold"
                                            >{{ market.pair }}</span
                                        >
                                    </router-link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
// component
export default {
    props: ["pairs", "provider"],
    // component list
    components: {},

    // component data
    data() {
        return {
            favs: null,
            old: [],
            markets: null,
            activeItem: "fav",
            status: true,
        };
    },
    computed: {},

    watch: {
        $route(to, from) {
            this.loop();
        },
    },

    // custom methods
    methods: {
        fetchMarkets() {
            this.$http.get("/data/markets/markets.json").then((response) => {
                if (this.provider != null) {
                    this.markets = response.data[this.provider];
                } else {
                    this.markets = response.data["kucoin"];
                }
            });
        },
        fetchFavs() {
            this.$http.post("/user/watchlist/data").then((response) => {
                this.favs = response.data.favs;
            });
        },
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
        scrollLeft() {
            var leftPos = $(".nf").scrollLeft();
            $(".nf").animate({ scrollLeft: leftPos - 200 }, 800);
        },
        scrollRight() {
            var leftPos = $(".nf").scrollLeft();
            $(".nf").animate({ scrollLeft: leftPos + 200 }, 800);
        },
        addToWatchlist(currency, pair) {
            this.$http
                .post("/user/watchlist/store", {
                    currency: currency,
                    pair: pair,
                })
                .then((response) => {
                    this.$toast[response.data.type](response.data.message);
                    this.fetchFavs();
                })
                .catch((error) => {
                    this.$toast.error(error.response.data);
                });
        },
        removeFromWatchlist(id) {
            this.$http
                .post("/user/watchlist/delete", {
                    id: id,
                })
                .then((response) => {
                    this.$toast.success(response.data.message);
                    this.fetchFavs();
                })
                .catch((error) => {
                    this.$toast.error("Market Already Removed From Watchlist");
                });
        },
        handle(tickers) {
            this.tickerElements = this.tickerElements || {};
            this.tickerIcons = this.tickerIcons || {};
            this.changeElements = this.changeElements || {};
            for (const [symbol, ticker] of Object.entries(tickers)) {
                const symbolWithoutSlash = symbol.replace("/", "");
                if (!(symbol in this.tickerElements)) {
                    this.tickerElements[symbol] = $(
                        ".tic-" + symbolWithoutSlash
                    );
                }
                if (!(symbol in this.tickerIcons)) {
                    this.tickerIcons[symbol] = $(
                        ".tic-" + symbolWithoutSlash + "-icon"
                    );
                }
                const tickerElement = this.tickerElements[symbol];
                const tickerIcon = this.tickerIcons[symbol];
                if (!this.old[symbol] || ticker["last"] > this.old[symbol]) {
                    tickerElement.text(ticker["last"]);
                    tickerElement.toggleClass("text-success");
                    tickerIcon.toggleClass("bi-arrow-up text-success");
                } else if (ticker["last"] < this.old[symbol]) {
                    tickerElement.text(ticker["last"]);
                    tickerElement.toggleClass("text-danger");
                    tickerIcon.toggleClass("bi-arrow-down text-danger");
                }
                this.old[symbol] = ticker["last"];
                if (!(symbol in this.changeElements)) {
                    this.changeElements[symbol] = $(
                        ".change-" + symbolWithoutSlash
                    );
                }
                const changeElement = this.changeElements[symbol];
                if (ticker["change"] > 0) {
                    changeElement.text(
                        this.formatTotal(ticker["change"]) + "%"
                    );
                    changeElement
                        .addClass("text-success")
                        .removeClass("text-danger");
                } else if (ticker["change"] < 0) {
                    changeElement.text(
                        this.formatTotal(ticker["change"]) + "%"
                    );
                    changeElement
                        .addClass("text-danger")
                        .removeClass("text-success");
                } else {
                    changeElement.text(
                        this.formatTotal(ticker["change"]) + "%"
                    );
                }
            }
        },
        contains(target, pattern) {
            var value = 0;
            pattern.forEach(function (word) {
                value = value + target.includes(word);
            });
            return value === 1;
        },
        async loop() {
            while (
                this.contains(this.$route.path, [
                    this.$route.params.symbol +
                        "/" +
                        this.$route.params.currency,
                ])
            ) {
                if (document.hidden) {
                    await ccxt.sleep(1000);
                    continue;
                }
                try {
                    const tickers = await exchange.fetchTickers();
                    this.handle(tickers);
                } catch (e) {
                    break;
                }
            }
        },
        formatTotal(total) {
            return ccxt.decimalToPrecision(
                total,
                ccxt.ROUND,
                3,
                ccxt.DECIMAL_PLACES,
                ccxt.PAD_WITH_ZERO
            );
        },
        async wsClose() {
            this.status = false;
            await exchange.close();
        },
    },

    // on component created
    created() {
        this.fetchFavs();
        this.fetchMarkets();
    },

    // on component mounted
    mounted() {
        this.loop();
    },
    // on component mounted
    beforeUpdate() {
        this.pairs.forEach((pair) => {
            var tr_elements = $(".custom-data-table-" + pair + " tbody tr");
            $(document).on("input", "input[name=search_table]", function () {
                var search = $(this).val().toUpperCase();
                var match = tr_elements
                    .filter(function (idx, elem) {
                        return $(elem)
                            .text()
                            .trim()
                            .toUpperCase()
                            .indexOf(search) >= 0
                            ? elem
                            : null;
                    })
                    .sort();
                var table_content = $(".custom-data-table-" + pair + " tbody");
                if (match.length == 0) {
                    table_content.html(
                        '<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>'
                    );
                } else {
                    table_content.html(match);
                }
            });
        });
        var tr_elements = $(".custom-data-table-fav tbody tr");
        $(document).on("input", "input[name=search_table_fav]", function () {
            var search = $(this).val().toUpperCase();
            var match = tr_elements
                .filter(function (idx, elem) {
                    return $(elem)
                        .text()
                        .trim()
                        .toUpperCase()
                        .indexOf(search) >= 0
                        ? elem
                        : null;
                })
                .sort();
            var table_content = $(".custom-data-table-fav tbody");
            if (match.length == 0) {
                table_content.html(
                    '<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>'
                );
            } else {
                table_content.html(match);
            }
        });
    },
    unmounted() {
        this.wsClose();
    },
    // on component destroyed
    destroyed() {
        this.wsClose();
    },
};
</script>
<style>
.not-watchlisted:hover .bi-star {
    color: rgb(255, 159, 67) !important;
}
.watchlisted:hover .bi-star-fill {
    color: rgb(130, 134, 139) !important;
}
</style>
