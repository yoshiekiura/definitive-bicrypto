<template>
    <div>
        <page-header :configData="configData" />
        <page-menu :configData="configData" :usermenuData="usermenuData" />
        <div class="app-content content" :class="configData['pageClass']">
            <!-- BEGIN: Header-->
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>

            <div
                v-if="
                    configData['contentLayout'] !== 'default' &&
                    configData['contentLayout']
                "
                class="content-area-wrapper"
                :class="
                    configData['layoutWidth'] === 'boxed'
                        ? 'container-xxl p-0'
                        : ''
                "
            >
                <div :class="configData['sidebarPositionClass']">
                    <div class="sidebar"></div>
                </div>
                <div :class="configData['contentsidebarClass']">
                    <div class="content-wrapper">
                        <div class="content-body">
                            <keep-alive>
                                <router-view
                                    v-if="user !== null"
                                    :user="user"
                                    :kyc="kyc"
                                >
                                </router-view>
                            </keep-alive>
                        </div>
                    </div>
                </div>
            </div>
            <div
                v-else
                class="content-wrapper"
                :class="
                    configData['layoutWidth'] === 'boxed'
                        ? 'container-xxl p-0'
                        : ''
                "
            >
                <div class="content-body" id="content-body">
                    <Transition
                        type="animation"
                        name="zoom-fade"
                        mode="out-in"
                        :duration="300"
                    >
                        <keep-alive>
                            <router-view
                                v-if="user !== null"
                                :user="user"
                                :kyc="kyc"
                            >
                            </router-view>
                        </keep-alive>
                    </Transition>
                </div>
            </div>
        </div>
        <page-footer :configData="configData" />
    </div>
</template>

<script>
import DarkLight from "./ui/DarkLight.vue";
import PageFooter from "./ui/PageFooter.vue";
import PageHeader from "./ui/PageHeader.vue";
import PageMenu from "./ui/PageMenu.vue";
import SubMenu from "./ui/SubMenu.vue";

export default {
    // component list
    components: {
        SubMenu,
        DarkLight,
        PageFooter,
        PageHeader,
        PageMenu,
    },
    // component data
    data() {
        return {
            mainComp: "",
            usermenuData: usermenuData,
            configData: configData,
            user: null,
            kyc: null,
        };
    },
    // custom methods
    methods: {
        fetchData() {
            this.$http.post("/user/fetch/data").then((response) => {
                (this.kyc = response.data.kyc),
                    (this.user = response.data.user);
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

        if (plat.trading.binary_status == 1) {
            const Binary = () => import("./Pages/binary/Binary.vue");
            const BinaryTrading = () =>
                import("./Pages/binary/BinaryTrading.vue");
            const PracticeContracts = () =>
                import("./Pages/binary/logs/Practice.vue");
            const TradeContracts = () =>
                import("./Pages/binary/logs/Trade.vue");
            const ContractPreview = () =>
                import("./Pages/binary/logs/Preview.vue");
            this.$router.addRoute({
                path: "/binary",
                component: Binary,
                meta: { title: "Binary Dashboard" },
            });
            this.$router.addRoute({
                path: "/binary/:type/:symbol/:currency",
                component: BinaryTrading,
                meta: { title: "Binary Trading" },
            });
            this.$router.addRoute({
                path: "/binary/practice/contracts",
                component: PracticeContracts,
                meta: { title: "Binary Practice Logs" },
            });
            this.$router.addRoute({
                path: "/binary/trade/contracts",
                component: TradeContracts,
                meta: { title: "Binary Trading Logs" },
            });
            this.$router.addRoute({
                path: "/binary/contract/view/:type/:id",
                component: ContractPreview,
                meta: { title: "Binary Contract Preview" },
            });
        }
        if (ext.botTrader == 1) {
            const Bots = () => import("./Pages/bot/Bots.vue");
            const BotTradePage = () => import("./Pages/bot/BotTradePage.vue");
            this.$router.addRoute({
                path: "/bot",
                component: Bots,
                meta: { title: "Bots Dashboard" },
            });
            this.$router.addRoute({
                path: "/bot/:symbol/:currency",
                component: BotTradePage,
                meta: { title: "Forex Trading" },
            });
        }
        if (ext.ico == 1) {
            const ICO = () => import("./Pages/ico/ICO.vue");
            const ICODetails = () => import("./Pages/ico/ICODetails.vue");
            this.$router.addRoute({
                path: "/ico",
                component: ICO,
                meta: { title: "Token Offers" },
            });
            this.$router.addRoute({
                path: "/ico/:symbol",
                component: ICODetails,
                meta: { title: "Offer Details" },
            });
        }
        if (ext.forex == 1) {
            const Forex = () => import("./Pages/Forex/Forex.vue");
            const ForexTrading = () => import("./Pages/Forex/Trading.vue");
            this.$router.addRoute({
                path: "/forex",
                component: Forex,
                meta: { title: "Forex Dashboard" },
            });
            this.$router.addRoute({
                path: "/forex/trade",
                component: ForexTrading,
                meta: { title: "Forex Trading" },
            });
        }
        if (ext.staking == 1) {
            const Staking = () => import("./Pages/staking/Staking.vue");
            const StakingLogs = () => import("./Pages/staking/StakingLogs.vue");
            this.$router.addRoute({
                path: "/staking",
                component: Staking,
                meta: { title: "Staking Dashboard" },
            });
            this.$router.addRoute({
                path: "/staking/logs",
                component: StakingLogs,
                meta: { title: "Staking Logs" },
            });
        }
        if (ext.builder == 1) {
            const PageBuilder = () => import("./Pages/builder/PageBuilder.vue");
            this.$router.addRoute({
                path: "/page/:slug",
                component: PageBuilder,
            });
        }
    },
    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
<style lang="scss">
// ///////////////////////////////////////////////
// Zoom Fade
// ///////////////////////////////////////////////
.zoom-fade-enter-active,
.zoom-fade-leave-active {
    transition: transform 0.35s, opacity 0.28s ease-in-out;
}
.zoom-fade-enter {
    transform: scale(0.97);
    opacity: 0;
}

.zoom-fade-leave-to {
    transform: scale(1.03);
    opacity: 0;
}

// ///////////////////////////////////////////////
// Fade Regular
// ///////////////////////////////////////////////
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.28s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

// ///////////////////////////////////////////////
// Page Slide
// ///////////////////////////////////////////////
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.35s, transform 0.4s;
}
.slide-fade-enter {
    opacity: 0;
    transform: translateX(-30%);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(30%);
}

// ///////////////////////////////////////////////
// Zoom Out
// ///////////////////////////////////////////////
.zoom-out-enter-active,
.zoom-out-leave-active {
    transition: opacity 0.35s ease-in-out, transform 0.45s ease-out;
}
.zoom-out-enter,
.zoom-out-leave-to {
    opacity: 0;
    transform: scale(0);
}

// ///////////////////////////////////////////////
// Fade Bottom
// ///////////////////////////////////////////////

// Speed: 1x
.fade-bottom-enter-active,
.fade-bottom-leave-active {
    transition: opacity 0.3s, transform 0.35s;
}
.fade-bottom-enter {
    opacity: 0;
    transform: translateY(-8%);
}

.fade-bottom-leave-to {
    opacity: 0;
    transform: translateY(8%);
}

// Speed: 2x
.fade-bottom-2x-enter-active,
.fade-bottom-2x-leave-active {
    transition: opacity 0.2s, transform 0.25s;
}
.fade-bottom-2x-enter {
    opacity: 0;
    transform: translateY(-4%);
}

.fade-bottom-2x-leave-to {
    opacity: 0;
    transform: translateY(4%);
}

// ///////////////////////////////////////////////
// Fade Top
// ///////////////////////////////////////////////

// Speed: 1x
.fade-top-enter-active,
.fade-top-leave-active {
    transition: opacity 0.3s, transform 0.35s;
}
.fade-top-enter {
    opacity: 0;
    transform: translateY(8%);
}

.fade-top-leave-to {
    opacity: 0;
    transform: translateY(-8%);
}

// Speed: 2x
.fade-top-2x-enter-active,
.fade-top-2x-leave-active {
    transition: opacity 0.2s, transform 0.25s;
}
.fade-top-2x-enter {
    opacity: 0;
    transform: translateY(4%);
}

.fade-top-2x-leave-to {
    opacity: 0;
    transform: translateY(-4%);
}

///////////////////////////////////////////////////////////
// transition-group : list;
///////////////////////////////////////////////////////////
.list-leave-active {
    position: absolute;
}

.list-enter,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

///////////////////////////////////////////////////////////
// transition-group : list-enter-up;
///////////////////////////////////////////////////////////
.list-enter-up-leave-active {
    transition: none !important;
}

.list-enter-up-enter {
    opacity: 0;
    transform: translateY(30px);
}
</style>
