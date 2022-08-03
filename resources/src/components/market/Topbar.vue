<template>
    <header
        class="topbar-wrap shadow"
        style="background: rgb(255 255 255 / 6%)"
        :class="{ collapsed: header.collapsed }"
    >
        <div class="mx-1">
            <!-- main topbar row with logo and buttons -->
            <div
                class="topbar-main d-flex justify-content-between align-items-center"
            >
                <!-- topbar top tokens
                <div
                    class="topbar-prices flex-row flex-middle flex-1"
                    v-if="options.prices.header"
                >
                    <a
                        v-for="(a, i) in marketPrices"
                        :key="a.token"
                        class="text-clip clickable fx fx-slide-down"
                        :class="'fx-delay-' + (i + 1)"
                        @click="showPair(a.route)"
                    >
                        <span class="text-dark">{{ a.token }}</span>
                        <span
                            :class="{
                                'text-gain': a.percent > 0,
                                'text-loss': a.percent < 0,
                            }"
                            >{{ a.sign }}{{ a.percent | toFixed(3) }}%</span
                        >
                        <br />
                        <span class="text-secondary">{{
                            a.close | toFixed(a.market)
                        }}</span>
                        <span class="text-faded">{{ a.market }}</span>
                    </a>
                </div>-->

                <!-- topbar buttons and menu -->
                <div
                    class="topbar-menu d-flex justify-content-end align-items-center w-100"
                >
                    <button
                        class="topbar-btn bi"
                        :class="{
                            'bi-eye text-danger pulse': watching,
                            'bi-eye-slash text-grey': !watching,
                        }"
                        @click="
                            $bus.emit('toggleWatchform', 'toggle'),
                                (watching = !watching)
                        "
                    ></button>

                    <div class="dropdown">
                        <i
                            class="topbar-btn bi"
                            id="Pricemenu"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            :class="{
                                ' bi-wifi text-gain': tickerStatus,
                                ' bi-wifi-off text-danger': !tickerStatus,
                            }"
                        ></i>
                        <div
                            class="dropdown-menu text-center"
                            aria-labelledby="Pricemenu"
                        >
                            <div class="dropdown-item form-label px-1">
                                Price Ticker Connection
                            </div>

                            <hr />
                            <div class="dropdown-item px-1 mb-1">
                                <span class="text-secondary">Status:</span>
                                &nbsp;
                                <span v-if="tickerStatus == 0" class="text-loss"
                                    >Disconnected <i class="bi bi-wifi-off"></i
                                ></span>
                                <span
                                    v-if="tickerStatus == 1"
                                    class="text-primary"
                                    >Connecting... <i class="bi bi-clock"></i
                                ></span>
                                <span v-if="tickerStatus == 2" class="text-gain"
                                    >Connected <i class="bi bi-check"></i
                                ></span>
                                <br />
                                <span class="text-secondary">Time:</span> &nbsp;
                                <span class="text-dark">{{ tickerTime }}</span>
                            </div>

                            <div class="dropdown-item px-1">
                                <button
                                    v-if="tickerStatus"
                                    class="form-btn bi bi-x-lg iconLeft bg-danger-hover"
                                    @click="toggleConnection"
                                >
                                    Disconnect
                                </button>
                                <button
                                    v-else
                                    class="form-btn bi bi-plug iconLeft bg-success-hover"
                                    @click="toggleConnection"
                                >
                                    Connect
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        class="dropdown"
                        :class="{ 'alert-bubble': hasBubble }"
                    >
                        <i
                            class="topbar-btn bi bi-list"
                            id="Mainmenu"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        ></i>
                        <ul class="dropdown-menu" aria-labelledby="Mainmenu">
                            <li class="dropdown-item">
                                <span class="form-label">Main Navigation</span>
                            </li>
                            <!-- <li class="dropdown-item clickable text-dark" @click="setRoute('/market/news">
                <i class="bi bi-twitter"></i> Twitter News <span class="text-grey" v-if="newsCount">({{ newsCount }})</span>
              </li> -->
                            <li
                                class="dropdown-item clickable text-dark"
                                @click="setModal('/market/alarms')"
                            >
                                <i class="bi bi-alarm"></i> Saved Alarms
                                <span class="text-grey" v-if="alarmsData.length"
                                    >({{ alarmsData.length }})</span
                                >
                            </li>
                            <li
                                class="dropdown-item clickable text-dark"
                                @click="setModal('/market/history')"
                            >
                                <i class="bi bi-clock"></i> Recent History
                                <span
                                    class="text-grey"
                                    v-if="historyData.length"
                                    >({{ historyData.length }})</span
                                >
                            </li>
                            <!-- <li class="dropdown-item clickable text-dark" @click="setRoute('/market/trade">
                <i class="bi bi-percent"></i> Trade Bot
              </li> -->
                            <li
                                class="dropdown-item clickable text-dark"
                                @click="setModal('/market/options')"
                            >
                                <i class="bi bi-gear"></i> Options
                            </li>
                            <!-- <li class="dropdown-item clickable text-dark" @click="setRoute('/market/about">
                <i class="bi bi-info-circle"></i> Info
              </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
// component
export default {
    // component props
    props: {
        header: {
            type: Object,
            default() {
                return {};
            },
        },
        options: {
            type: Object,
            default() {
                return {};
            },
        },
        priceData: {
            type: Array,
            default() {
                return [];
            },
        },
        historyData: {
            type: Array,
            default() {
                return [];
            },
        },
        alarmsData: {
            type: Array,
            default() {
                return [];
            },
        },
        newsEntries: {
            type: Array,
            default() {
                return [];
            },
        },
        tickerStatus: { type: Number, default: 0 },
        tickerTime: { type: String, default: "" },
    },

    // component data
    data() {
        return {
            watching: false,
        };
    },

    // computed methods
    computed: {
        // compute number of active alarms for all tokens
        alarmsCount() {
            return this.alarmsData.filter((e) => e.active).length | 0;
        },

        // compute number of "new" history entries
        historyCount() {
            return this.historyData.filter((e) => e.isNew).length | 0;
        },

        // compute number of "new" news entries
        newsCount() {
            return this.newsEntries.filter((e) => e.isNew).length | 0;
        },

        // check if alert button should be visible
        hasBubble() {
            return this.historyCount || this.newsCount;
        },

        // get top 3 usdt coins based on volume
        marketPrices() {
            let market = this.options.prices.market || "USDT";
            let list = this.priceData.filter((p) => p.market === market);
            return this.$utils.sort(list, "percent", "desc").slice(0, 3);
        },
    },
    // custom methods
    methods: {
        // toggle socket connection
        toggleConnection() {
            if (this.tickerStatus) {
                this.$binance.stopTickerStream();
            } else {
                this.$binance.startTickerStream(true);
            }
        },
    },

    // on component created
    created() {
        this.$bus.on("priceWatch", (status) => {
            this.watching = status;
        });
    },
};
</script>

<style lang="scss">
@import "../../scss/variables";
// topbar wrapper
.topbar-wrap {
    display: block;
    position: relative;
    left: 0;
    top: 0;
    width: 100%;
    z-index: ($zindexElements + 10);

    // main topbar container
    .topbar-main {
        height: $topbarHeight;

        // top asset prices
        .topbar-prices {
            font-size: 80%;
            line-height: 1.1em;
            letter-spacing: 0;
            font-weight: normal;

            & > div {
                margin-left: calc($padSpace / 1.5);
                padding-left: calc($padSpace / 1.5);
                border-left: $lineWidth $lineStyle $lineColor;
            }

            @media #{$screenSmall} {
                letter-spacing: 1px;

                & > div {
                    margin-left: $padSpace;
                    padding-left: $padSpace;
                }
            }
        }
        @media (max-width: 576px) {
            .topbar-prices {
                display: none;
            }
            .topbar-btn {
                float: right;
            }
        }
        // button/links
        .topbar-btn {
            display: inline-block;
            margin: 0 0 0 0.5em;
            font-size: 180%;
            line-height: 1em;
            color: $colorDefault;

            &.pulse {
                animation: pulseFade 1s linear infinite;
            }

            &:before {
                opacity: 1;
            }
            &:hover:before {
                opacity: 0.8;
            }
        }
        // dropdown component
        .topbar-dropdown {
            display: inline-block;
            position: relative;
        }
    }

    // collapsed mode
    &.collapsed {
        transform: translateY(-#{$topbarHeight});
    }
}
</style>
